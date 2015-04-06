<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// get extension configuration
$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jh_magnificpopup']);

// Add frontend plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Magnific Popup'
);

// Add flexform for frontend plugin
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/MagnificpopupPlugin.xml');

// Add static files
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Default', 'Magnific Popup');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/RTELightbox', 'Magnific Popup for RTE');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Inline', 'Magnific Popup - Content Element');

// Wizard for frontend plugin
if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'][$pluginSignature . '_wizicon'] =
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Private/Php/class.' . $_EXTKEY . '_wizicon.php';
}

// Add colPos for content elements
if (TYPO3_MODE == 'BE') {
	if (! isset($TCA['tt_content']['columns']['colPos']['config']['items'][$confArr['colPosOfIrreContent']])) {
		// Add the new colPos to the array, only if the ID does not exist...
		$TCA['tt_content']['columns']['colPos']['config']['items'][$confArr['colPosOfIrreContent']] = array ($_EXTKEY, $confArr['colPosOfIrreContent']);
	}
}

?>