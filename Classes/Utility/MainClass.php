<?php
namespace JonathanHeilmann\JhMagnificpopup\Utility;

use TYPO3\CMS\Backend\Utility\BackendUtility;

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

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * MainClass utility class
 * originally from EXT:news
 *
 */
class MainClass implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * Get available template layouts for a certain page
     *
     * @param int $pageUid
     * @return array
     */
    public function getAvailableMainClass($pageUid)
    {
        $templateLayouts = array();

        // Check if the layouts are extended by ext_tables
        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['jh_magnificpopup']['mainClass'])
            && is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['jh_magnificpopup']['mainClass'])) {
            $templateLayouts = $GLOBALS['TYPO3_CONF_VARS']['EXT']['jh_magnificpopup']['mainClass'];
        }

        // Add TsConfig values
        foreach ($this->getTemplateLayoutsFromTsConfig($pageUid) as $animation => $class) {
            $templateLayouts[] = array($animation, $class);
        }

        return $templateLayouts;
    }

    /**
     * Get template layouts defined in TsConfig
     *
     * @param $pageUid
     * @return array
     */
    protected function getTemplateLayoutsFromTsConfig($pageUid)
    {
        $templateLayouts = array();
        $pagesTsConfig = BackendUtility::getPagesTSconfig($pageUid);
        if (isset($pagesTsConfig['tx_jhmagnificpopup.']['mainClass.']) && is_array($pagesTsConfig['tx_jhmagnificpopup.']['mainClass.'])) {
            $templateLayouts = $pagesTsConfig['tx_jhmagnificpopup.']['mainClass.'];
        }
        return $templateLayouts;
    }
}
