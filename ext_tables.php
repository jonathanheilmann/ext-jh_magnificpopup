<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// get extension configuration
$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jh_magnificpopup']);

// Add frontend plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'JonathanHeilmann.' . $_EXTKEY,
    'Pi1',
    'Magnific Popup'
);

// Add flexform for frontend plugin
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature,
    'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/MagnificpopupPlugin.xml');
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';

// Add static files
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Default',
    'Magnific Popup');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Inline',
    'Magnific Popup - Content Element');

// Add colPos for content elements
if (TYPO3_MODE == 'BE') {
    if (!isset($GLOBALS['TCA']['tt_content']['columns']['colPos']['config']['items'][$confArr['colPosOfIrreContent']])) {
        // Add the new colPos to the array, only if the ID does not exist...
        $GLOBALS['TCA']['tt_content']['columns']['colPos']['config']['items'][$confArr['colPosOfIrreContent']] = array(
            $_EXTKEY,
            $confArr['colPosOfIrreContent']
        );
    }
}

// Add special mfp palette
$GLOBALS['TCA']['sys_file_reference']['palettes']['mfpPalette'] = array(
    'showitem' => 'title, alternative;;;;3-3-3,--linebreak--, description',
    'canNotCollapse' => true
);
