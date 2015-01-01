<?php
namespace TYPO3\JhMagnificpopup\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Jonathan Heilmann <mail@jonathan-heilmann.de>, Webprogrammierung Jonathan Heilmann
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

 use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;
 use \TYPO3\CMS\Core\Messaging\AbstractMessage;
 use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 *
 * @package jh_magnificpopup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MagnificpopupController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * magnificpopupRepository
	 *
	 * @var \TYPO3\JhMagnificpopup\Domain\Repository\magnificpopupRepository
	 * @inject
	 */
	protected $magnificPopupRepository;

	/**
	 * SignalSlotDispatcher
	 *
	 * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
	 * @inject
	 */
	protected $signalSlotDispatcher;

	/**
	 * action show
	 *
	 * @return void
	 */
	public function showAction() {
		// Flush all messages
		$this->flashMessageContainer->flush();
		// Assign multiple values
		$viewAssign = array();
		$this->cObj = $this->configurationManager->getContentObject();
		$this->data = $this->cObj->data;
		$viewAssign['uid'] = $this->data['uid'];

		switch ($this->settings['contenttype']) {
			case 'iframe':
				$viewAssign = GeneralUtility::array_merge($viewAssign, $this->iframe());
				break;
			case 'reference':
			case 'inline':
				if (($this->settings['content']['procedure_reference'] == 'ajax' && !empty($this->settings['contenttype'])) || $this->settings['content']['procedure_inline'] == 'ajax') {
					$viewAssign = GeneralUtility::array_merge($viewAssign, $this->ajax());
				} else if (($this->settings['content']['procedure_reference'] && !empty($this->settings['contenttype'])) == 'inline' || $this->settings['content']['procedure_inline'] == 'inline'){
					$viewAssign = GeneralUtility::array_merge($viewAssign, $this->inline());
				} else if ($this->settings['content']['procedure_reference'] == '' && $this->settings['content']['procedure_inline'] == '') {
					// Add error if no method (inline or ajax) has been selected
					$this->flashMessageContainer->add('Please select the method (inline or ajax) to display Magnific Popup content', 'Select method', AbstractMessage::WARNING);
				} else if ($this->settings['content']['procedure_reference'] != '' && empty($this->settings['contenttype'])) {
					// Add error if no content has been selected
					$this->flashMessageContainer->add('Please select a content to display with Magnific Popup', 'Select content', AbstractMessage::WARNING);
				}
				break;
			default:
				// Add error if no "Display type" has been selected
				$this->flashMessageContainer->add('Please select a "Display type" to use Magnific Popup', 'Select "Display type"', AbstractMessage::WARNING);
		}

		// Signal for show action (may be used to modify the array assigned to fluid-template)
		$this->signalSlotDispatcher->dispatch(
			__CLASS__,
			__FUNCTION__,
			array(
				'data' => $this->data,
				'settings' => $this->settings,
				'viewAssign' => &$viewAssign
			)
		);
		// Assign array to fluid-template
		$this->view->assignMultiple($viewAssign);
	}

	private function ajax() {
		$viewAssign['type'] = 'ajax';
		// Use ajax procedure
		$viewAssign['link-class'] = 'mfp-ajax-'.$this->data['uid'];
		if($this->settings['contenttype'] == 'reference') {
			// Get the list of pid's
			$uidList = $this->settings['content']['reference'];
			$uidArray = explode(',', $uidList);
			foreach($uidArray as $uid) {
				$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('pid', 'tt_content', 'uid='.$uid);
				$pidInList .= $row['pid'].',';
			}
			$pidInList = substr($pidInList, 0, -1);
			// Configure the link
			$linkconf = array();
			$linkconf['parameter'] = $this->data['pid'];
			if ($this->settings['useEidForAjaxMethod'] != 1) {
				$linkconf['additionalParams'] = '&type=109&jh_magnificpopup[type]=reference&jh_magnificpopup[uid]='.$this->settings['content']['reference'].'&jh_magnificpopup[pid]='.$pidInList;
			} else {
				$linkconf['additionalParams'] = '&eID=jh_magnificpopup_ajax&jh_magnificpopup[type]=reference&jh_magnificpopup[uid]='.$this->settings['content']['reference'].'&jh_magnificpopup[pid]='.$pidInList;
			}
		} else {
			// Configure the link
			$linkconf = array();
			$linkconf['parameter'] = $this->data['pid'];
			if ($this->settings['useEidForAjaxMethod'] != 1) {
				$linkconf['additionalParams'] = '&type=109&jh_magnificpopup[type]=inline&jh_magnificpopup[irre_parrentid]='.$this->data['uid'];
			} else {
				$linkconf['additionalParams'] = '&eID=jh_magnificpopup_ajax&jh_magnificpopup[type]=inline&jh_magnificpopup[irre_parrentid]='.$this->data['uid'];
			}
		}
		// Link-setup
		$viewAssign['link'] = $this->cObj->typolink_URL($linkconf);
		$viewAssign['link-text'] = $this->settings['mfpOption']['text'];

		// Get settings from flexform
		// If something else than the default from setup is selected or a value is empty use setting from flexform
		foreach($this->settings['mfpOption'] as $key => $value) {
			if($value != -1 && !empty($value)) {
				if ($value == 'local') {
					$this->settings['type']['ajax'][$key] = $this->settings['mfpOption'][$key.'_local'];
				} else {
					$this->settings['type']['ajax'][$key] = $value;
				}
			}
		}
		$viewAssign['settings'] = $this->settings;
		return $viewAssign;
	}

	private function inline() {
		$viewAssign['type'] = 'inline';
		// Use inline procedure
		// Render irre content as inline-htmlcode
		if($this->settings['contenttype'] == 'reference') {
			//get list of pid's
			$uidList = $this->settings['content']['reference'];
			$uidArray = explode(',', $uidList);
			foreach($uidArray as $uid) {
				$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('pid', 'tt_content', 'uid='.$uid);
				$pidInList .= $row['pid'].',';
			}
			$pidInList = substr($pidInList, 0, -1);
			// Configure the content
			$irre_conf = array(
				'table'	=> 'tt_content',
				'select.'	=> array(
					'where' => 'tt_content.uid IN('.$this->settings['content']['reference'].')',
					'languageField' => 'sys_language_uid',
					'pidInList' => $pidInList,
					'orderBy' => 'sorting'
				)
			);
		} else {
			// Configure the content
			$irre_conf = array(
				'table'	=> 'tt_content',
				'select.'	=> array(
					'where' => 'deleted=0 AND hidden=0 AND tx_jhmagnificpopup_irre_parentid = '.$this->data['uid'],
					'languageField' => 'sys_language_uid',
					'orderBy' => 'sorting'
				)
			);
		}
		// Render inlinecontent
		$viewAssign['inlinecontent'] = $this->cObj->CONTENT($irre_conf);
		$viewAssign['inlinecontent_id'] = 'mfp-inline-'.$this->data['uid'];
		// Link-setup
		$viewAssign['link-class'] = 'mfp-inline-'.$this->data['uid'];
		$viewAssign['link'] = '#mfp-inline-'.$this->data['uid'];
		$viewAssign['link-text'] = $this->settings['mfpOption']['text'];

		// Get settings from flexform
		// If something else than the default from setup is selected or a value is empty use setting from flexform
		foreach($this->settings['mfpOption'] as $key => $value) {
			if($value != -1 && !empty($value)) {
				if ($value == 'local') {
					$this->settings['type']['inline'][$key] = $this->settings['mfpOption'][$key.'_local'];
				} else {
					$this->settings['type']['inline'][$key] = $value;
				}
			}
		}
		$viewAssign['settings'] = $this->settings;
		return $viewAssign;
	}

	private function iframe() {
		$viewAssign['type'] = 'iframe';
		//$viewAssign['uid'] = $this->data['uid'];
		// Link-setup
		$viewAssign['link-class'] = 'mfp-iframe-'.$this->data['uid'];
		$viewAssign['link'] = $this->settings['mfpOption']['href'];
		$viewAssign['link-text'] = $this->settings['mfpOption']['text'];

		// Get settings from flexform
		// If something else than the default from setup is selected or a value is empty use setting from flexform
		foreach($this->settings['mfpOption'] as $key => $value) {
			if($value != -1 && !empty($value)) {
				if ($value == 'local') {
					$this->settings['type']['iframe'][$key] = $this->settings['mfpOption'][$key.'_local'];
				} else {
					$this->settings['type']['iframe'][$key] = $value;
				}
			}
		}
		$viewAssign['settings'] = $this->settings;
		return $viewAssign;
	}
}
?>