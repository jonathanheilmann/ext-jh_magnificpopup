<?php
namespace JonathanHeilmann\JhMagnificpopup\Hooks;

use JonathanHeilmann\JhMagnificpopup\Utility\MainClass;
use JonathanHeilmann\JhMagnificpopup\Utility\RemovalDelay;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 *
 *
 * @package jh_magnificpopup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ItemsProcFunc extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * Itemsproc function to extend the selection of mainClass in the plugin
     *
     * @param array &$config configuration array
     * @return void
     */
    public function user_mainClass(array &$config)
    {
        /** @var MainClass $templateLayoutsUtility */
        $templateLayoutsUtility = GeneralUtility::makeInstance(MainClass::class);
        $templateLayouts = $templateLayoutsUtility->getAvailableMainClass($config['row']['pid']);
        foreach ($templateLayouts as $layout) {
            $additionalLayout = array(
                $GLOBALS['LANG']->sL($layout[0], true),
                $layout[1]
            );
            array_push($config['items'], $additionalLayout);
        }
    }

    /**
     * Itemsproc function to extend the selection of emovalDelay in the plugin
     *
     * @param array &$config configuration array
     * @return void
     */
    public function user_removalDelay(array &$config)
    {
        /** @var RemovalDelay $templateLayoutsUtility */
        $templateLayoutsUtility = GeneralUtility::makeInstance(RemovalDelay::class);
        $templateLayouts = $templateLayoutsUtility->getAvailableRemovalDelay($config['row']['pid']);
        foreach ($templateLayouts as $layout) {
            $additionalLayout = array(
                $GLOBALS['LANG']->sL($layout[0], true),
                $layout[1]
            );
            array_push($config['items'], $additionalLayout);
        }
    }
}
