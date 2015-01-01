<?php
namespace Heilmann\JhMagnificpopup\Hooks;

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

/**
 *
 *
 * @package jh_magnificpopup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ItemsProcFunc extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Itemsproc function to extend the selection of mainClass in the plugin
	 *
	 * @param array &$config configuration array
	 * @return void
	 */
	public function user_mainClass(array &$config) {
		/** @var Tx_News_Utility_TemplateLayout $templateLayoutsUtility */
		$templateLayoutsUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Heilmann\JhMagnificpopup\Utility\MainClass');
		$templateLayouts = $templateLayoutsUtility->getAvailableMainClass($config['row']['pid']);
		foreach ($templateLayouts as $layout) {
			$additionalLayout = array(
				$GLOBALS['LANG']->sL($layout[0], TRUE),
				$layout[1]
			);
			array_push($config['items'], $additionalLayout);
		}
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($config);
	}

	/**
	 * Itemsproc function to extend the selection of emovalDelay in the plugin
	 *
	 * @param array &$config configuration array
	 * @return void
	 */
	public function user_removalDelay(array &$config) {
		/** @var Tx_News_Utility_TemplateLayout $templateLayoutsUtility */
		$templateLayoutsUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Heilmann\JhMagnificpopup\Utility\RemovalDelay');
		$templateLayouts = $templateLayoutsUtility->getAvailableRemovalDelay($config['row']['pid']);
		foreach ($templateLayouts as $layout) {
			$additionalLayout = array(
				$GLOBALS['LANG']->sL($layout[0], TRUE),
				$layout[1]
			);
			array_push($config['items'], $additionalLayout);
		}
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($config);
	}
}