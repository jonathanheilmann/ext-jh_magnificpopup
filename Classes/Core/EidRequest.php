<?php
namespace Heilmann\JhMagnificpopup\Core;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Jonathan Heilmann <mail@jonathan-heilmann.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Core\Bootstrap;
use TYPO3\CMS\Extbase\Service\TypoScriptService;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Utility\EidUtility;

/**
 * Class tu handle the eID request.
 */
class EidRequest {

	/**
	 * @var TypoScriptFrontendController $typoScriptFrontendController
	 */
	protected $typoScriptFrontendController = NULL;

	/**
	 *
	 *
	 * @return string
	 */
	public function run() {
		$cObject = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
		$gp = GeneralUtility::_GP('jh_magnificpopup');
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($GLOBALS['TSFE']->tmpl->setup['tt_content.']);
		//http://lists.typo3.org/pipermail/typo3-german/2011-July/079128.html
		switch ($gp['type']) {
			case 'inline':
				$cObjConfig = array(
					'name'	=>	'CONTENT',
					'conf'	=> array(
							'table' 	=>	'tt_content',
							'select.'	=> array(
								'where'		=> 'tx_jhmagnificpopup_irre_parentid='.$gp['irre_parrentid'],
								'pidInList'	=> (GeneralUtility::_GP('id')?:$GLOBALS["TSFE"]->id),
								'languageField'	=> 'sys_language_uid',
								'orderBy'	=> 'sorting',
							),
							'wrap'	=> '<div class="white-popup-block">|</div>',
							'renderObj'	=> $GLOBALS['TSFE']->tmpl->setup['tt_content'],
							'renderObj.'	=> $GLOBALS['TSFE']->tmpl->setup['tt_content.'],
					),
				);
				break;
			case 'reference':
				$pid = (isset($gp['pid']) && !empty($gp['pid']) ? $gp['pid'] : $GLOBALS["TSFE"]->id);
				$cObjConfig = array(
					'name'	=>	'CONTENT',
					'conf'	=> array(
							'table' 	=>	'tt_content',
							'select.'	=> array(
								'uidInList'		=> $gp['uid'],
								'pidInList'	=> $pid,
								'orderBy'	=> 'sorting',
								'languageField'	=> 'sys_language_uid',
							),
							'wrap'	=> '<div class="white-popup-block">|</div>',
							'renderObj'	=> $GLOBALS['TSFE']->tmpl->setup['tt_content'],
							'renderObj.'	=> $GLOBALS['TSFE']->tmpl->setup['tt_content.'],
					),
				);
				break;
			default:
				if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['jh_magnificpopup']['EidTypeHook']) {
				   if (!isset($gp['hookConf'])) $gp['hookConf'] = '';
				   $params = array(
				   	'type' => $gp['type'],
				   	'hookConf' => $gp['hookConf']
				   );
				   foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['jh_magnificpopup']['EidTypeHook'] as $_funcRef) {
				      if ($_funcRef) {
				         $cObjConfig = GeneralUtility::callUserFunction($_funcRef, $params, $this);
				         if (isset($cObjConfig['matchedType']) && $cObjConfig['matchedType'] === TRUE) {
				         	break;
				         }
				      }
				   }
				   if (isset($cObjConfig['matchedType']) && $cObjConfig['matchedType'] === FALSE) $cObjConfig = NULL;
				}
		}
		if (!empty($cObjConfig) && is_array($cObjConfig)) {
			$this->typoScriptFrontendController->content = $cObject->getContentObject($cObjConfig['name'])->render($cObjConfig['conf']);
		} else {
			$this->typoScriptFrontendController->content = 'ERROR - no (or wrong) configuration';
		}

		if ($GLOBALS['TSFE']->isINTincScript()) {
			$GLOBALS['TSFE']->INTincScript();
		}

		if (isset($cObjConfig['wrap']) && !empty($cObjConfig['wrap'])) {
			$this->typoScriptFrontendController->content = $cObject->wrap($this->typoScriptFrontendController->content, $cObjConfig['wrap']);
		}

		return $this->typoScriptFrontendController->content;
	}

	/**
	 * Initialize frontend environment
	 *
	 * @return void
	 */
	public function __construct() {
		$this->bootstrap = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Core\\Bootstrap');

		$feUserObj = EidUtility::initFeUser();

		$pageId = GeneralUtility::_GET('id') ?: 1;
		$pageType = GeneralUtility::_GET('type') ?: 0;

		/** @var TypoScriptFrontendController $typoScriptFrontendController */
		$this->typoScriptFrontendController = GeneralUtility::makeInstance(
			'TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController',
			$GLOBALS['TYPO3_CONF_VARS'],
			$pageId,
			$pageType,
			TRUE
		);
		$GLOBALS['TSFE'] = $this->typoScriptFrontendController;
		$this->typoScriptFrontendController->connectToDB();
		$this->typoScriptFrontendController->fe_user = $feUserObj;
		$this->typoScriptFrontendController->id = $pageId;
		$this->typoScriptFrontendController->determineId();
		$this->typoScriptFrontendController->checkAlternativeIdMethods();
		$this->typoScriptFrontendController->getCompressedTCarray();
		$this->typoScriptFrontendController->initTemplate();
		$this->typoScriptFrontendController->getConfigArray();
		$this->typoScriptFrontendController->includeTCA();
		$this->typoScriptFrontendController->settingLanguage();
		$this->typoScriptFrontendController->settingLocale();
	}

}