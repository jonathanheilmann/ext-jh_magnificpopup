<?php
namespace Heilmann\JhMagnificpopup\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Frans Saris <franssaris@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

/**
 * RemovalDelay utility class
 * originally from EXT:news
 *
 */
class RemovalDelay implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Get available template layouts for a certain page
	 *
	 * @param int $pageUid
	 * @return array
	 */
	public function getAvailableRemovalDelay($pageUid) {
		$templateLayouts = array();

		// Check if the layouts are extended by ext_tables
		if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['jh_magnificpopup']['removalDelay'])
			&& is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['jh_magnificpopup']['removalDelay'])) {
			$templateLayouts = $GLOBALS['TYPO3_CONF_VARS']['EXT']['jh_magnificpopup']['removalDelay'];
		}

		// Add TsConfig values
		foreach($this->getTemplateLayoutsFromTsConfig($pageUid) as $templateKey => $title) {
			$templateLayouts[] = array($templateKey, $title);
		}

		return $templateLayouts;
	}

	/**
	 * Get template layouts defined in TsConfig
	 *
	 * @param $pageUid
	 * @return array
	 */
	protected function getTemplateLayoutsFromTsConfig($pageUid) {
		$templateLayouts = array();
		$pagesTsConfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($pageUid);
		if (isset($pagesTsConfig['tx_jhmagnificpopup.']['removalDelay.']) && is_array($pagesTsConfig['tx_jhmagnificpopup.']['removalDelay.'])) {
			$templateLayouts = $pagesTsConfig['tx_jhmagnificpopup.']['removalDelay.'];
		}
		return $templateLayouts;
	}
}