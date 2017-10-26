<?php

namespace JonathanHeilmann\JhMagnificpopup\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2017 Jonathan Heilmann <mail@jonathan-heilmann.de>
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

use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class MagnificpopupController
 * @package Heilmann\JhMagnificpopup\Controller
 */
class MagnificpopupController extends ActionController
{

    /**
     * Array of supported content template packages/extensions
     *
     * @var array
     */
    protected static $supportedContentTemplateExtensions = [
        'bootstrap_package',
        'fluid_styled_content',
        'css_styled_content'
    ];

    /**
     * SignalSlotDispatcher
     *
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     * @inject
     */
    protected $signalSlotDispatcher;

    /**
     * PageRepository
     *
     * @var \TYPO3\CMS\Frontend\Page\PageRepository
     * @inject
     */
    protected $pageRepository;

    /**
     * ContentObject
     *
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $cObj;

    /**
     * Data
     *
     * @var array
     */
    protected $data;

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
        // Assign multiple values
        $viewAssign = array();
        $this->cObj = $this->configurationManager->getContentObject();
        $this->data = $this->cObj->data;

        // Get localized record
        $localizedRecord = $this->pageRepository->getRecordOverlay('tt_content', $this->data,
            $GLOBALS['TSFE']->sys_language_uid, $GLOBALS['TSFE']->sys_language_mode);
        if ($localizedRecord !== false && isset($localizedRecord['_LOCALIZED_UID'])) {
            $this->data = $localizedRecord;
        }

        $viewAssign['uid'] = $this->data['uid'];
        $viewAssign['data'] = $this->data;

        $viewAssign['contentTemplateExtension'] = 'custom';
        foreach (self::$supportedContentTemplateExtensions as $contentTemplateExtension) {
            if (ExtensionManagementUtility::isLoaded($contentTemplateExtension)) {
                $viewAssign['contentTemplateExtension'] = $contentTemplateExtension;
                break;
            };
        }

        switch ($this->settings['contenttype']) {
            case 'iframe':
                $viewAssign = $this->iframe() + $viewAssign;
                break;
            case 'reference':
            case 'inline':
                if (
                    ($this->settings['content']['procedure_reference'] == 'ajax'
                        && !empty($this->settings['contenttype'])
                    ) || $this->settings['content']['procedure_inline'] == 'ajax') {
                    $viewAssign = $this->ajax() + $viewAssign;
                } elseif (
                    ($this->settings['content']['procedure_reference'] == 'inline'
                        && !empty($this->settings['contenttype'])
                    ) || $this->settings['content']['procedure_inline'] == 'inline') {
                    $viewAssign = $this->inline() + $viewAssign;
                } elseif ($this->settings['content']['procedure_reference'] == '' && $this->settings['content']['procedure_inline'] == '') {
                    // Add error if no method (inline or ajax) has been selected
                    $this->addFlashMessage('Please select the method (inline or ajax) to display Magnific Popup content',
                        'Select method', AbstractMessage::WARNING);
                } elseif ($this->settings['content']['procedure_reference'] != '' && empty($this->settings['contenttype'])) {
                    // Add error if no content has been selected
                    $this->addFlashMessage('Please select a content to display with Magnific Popup', 'Select content',
                        AbstractMessage::WARNING);
                }
                break;
            default:
                // Add error if no "Display type" has been selected
                $this->addFlashMessage('Please select a "Display type" to use Magnific Popup', 'Select "Display type"',
                    AbstractMessage::WARNING);
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

    /**
     * @return array
     */
    protected function ajax()
    {
        $viewAssign['type'] = 'ajax';
        // Use ajax procedure
        if ($this->settings['contenttype'] == 'reference') {
            // Get the list of pid's
            $uidArray = explode(',', $this->settings['content']['reference']);
            $pidInList = array();
            foreach ($uidArray as $uid) {
                $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('pid', 'tt_content', 'uid=' . $uid);
                $pidInList[] = $row['pid'];
            }
            // Configure the link
            $linkconf['parameter'] = $this->data['pid'];
            $linkconf['additionalParams'] = '&' .
                ($this->settings['useEidForAjaxMethod'] != 1 ? 'type=109' : 'eID=jh_magnificpopup_ajax') .
                '&jh_magnificpopup[type]=reference&jh_magnificpopup[uid]=' . $this->settings['content']['reference'] .
                '&jh_magnificpopup[pid]=' . implode(',', $pidInList);
        } else {
            // Configure the link
            $linkconf['parameter'] = $this->data['pid'];
            $linkconf['additionalParams'] = '&' .
                ($this->settings['useEidForAjaxMethod'] != 1 ? 'type=109' : 'eID=jh_magnificpopup_ajax') .
                '&jh_magnificpopup[type]=inline&jh_magnificpopup[irre_parrentid]=' . $this->data['uid'];
        }
        // Link-setup
        $lConf = array();
        $lConf['ATagParams'] = 'class="mfp-ajax-' . $this->data['uid'] . '"';
        $lConf['parameter'] = $linkconf['parameter'];
        $lConf['additionalParams'] = $linkconf['additionalParams'];

        if ($this->settings['linktype'] == 'file') {
            ArrayUtility::mergeRecursiveWithOverrule($viewAssign, $this->renderLinktypeFile($lConf));
        } else {
            $viewAssign['tsLink'] = $this->cObj->typoLink($this->settings['mfpOption']['text'], $lConf);
        }

        // Get settings from flexform
        $this->getSettingsFromFlexform('ajax');

        $viewAssign['settings'] = $this->settings;
        return $viewAssign;
    }

    /**
     * @return array
     */
    protected function inline()
    {
        $viewAssign['type'] = 'inline';

        // Link-setup
        $lConf['ATagParams'] = 'class="mfp-inline-' . $this->data['uid'] . '" data-mfp-src="#mfp-inline-' . $this->data['uid'] . '"';
        $lConf['parameter'] = $GLOBALS['TSFE']->id;

        if ($this->settings['linktype'] == 'file') {
            ArrayUtility::mergeRecursiveWithOverrule($viewAssign, $this->renderLinktypeFile($lConf));
        } else {
            $viewAssign['tsLink'] = $this->cObj->typoLink($this->settings['mfpOption']['text'], $lConf);
        }

        // Get settings from flexform
        $this->getSettingsFromFlexform('inline');

        $viewAssign['settings'] = $this->settings;
        return $viewAssign;
    }

    /**
     * @return array
     */
    protected function iframe()
    {
        $viewAssign['type'] = 'iframe';

        // Link-setup
        $lConf = $this->configureLink($selectorClass = 'mfp-iframe-' . $this->data['uid']);

        if ($this->settings['linktype'] == 'file') {
            ArrayUtility::mergeRecursiveWithOverrule($viewAssign, $this->renderLinktypeFile($lConf));
        } else {
            $viewAssign['tsLink'] = $this->cObj->typoLink($this->settings['mfpOption']['text'], $lConf);
        }

        // Get settings from flexform
        $this->getSettingsFromFlexform('iframe');

        $viewAssign['settings'] = $this->settings;
        return $viewAssign;
    }

    /**
     * Configure the link
     *
     * @param string $selectorClass
     * @return array
     */
    protected function configureLink($selectorClass)
    {
        $lConf = array();
        // Modify parameter to add jQuery selector class to link
        $parameter = $this->settings['mfpOption']['href'];
        $parameters = GeneralUtility::unQuoteFilenames($parameter, true);
        if (count($parameters) >= 3) {
            $parameters[2] = $parameters[2] . ' ' . $selectorClass;
            // Quote values (has been unquoted by GeneralUtility::unQuoteFilenames)
            foreach ($parameters as $key => $value) {
                $parameters[$key] = '"' . $value . '"';
            }
            $parameter = implode(' ', $parameters);
        } else {
            $lConf['ATagParams'] = 'class="' . $selectorClass . '"';
        }

        $lConf['parameter'] = $parameter;

        return $lConf;
    }

    /**
     * Render link of type file
     *
     * @param array $lConf
     * @return array
     */
    protected function renderLinktypeFile($lConf)
    {
        $viewAssign = array();

        // Get file
        /** @var FileRepository $fileRepository */
        $fileRepository = $this->objectManager->get(FileRepository::class);
        $fileObjects = $fileRepository->findByRelation(
            'tt_content',
            'mfp_image',
            isset($this->data['_LOCALIZED_UID']) ? $this->data['_LOCALIZED_UID'] : $this->data['uid']
        );

        if (!empty($fileObjects)) {
            /** @var \TYPO3\CMS\Core\Resource\FileReference $file */
            $file = $fileObjects[0];
            $this->cObj->setCurrentFile($file->getOriginalFile());
            $imageConf = $GLOBALS['TSFE']->tmpl->setup['lib.']['tx_jhmagnificpopup_pi1.']['image.'];
            $imageConf['file.']['treatIdAsReference'] = 1;
            $imageConf['file'] = $file;
            $imageConf['altText'] = $file->getProperty('alternative');
            $imageConf['titleText'] = $file->getProperty('title');
            if (isset($this->settings['mfpOption']['file_width']) && !empty($this->settings['mfpOption']['file_width'])) {
                $imageConf["file."]["maxW"] = $this->settings['mfpOption']['file_width'];
            }

            if (isset($this->settings['mfpOption']['file_height']) && !empty($this->settings['mfpOption']['file_height'])) {
                $imageConf["file."]["maxH"] = $this->settings['mfpOption']['file_height'];
            }

            // Render image
            $theImgCode = $this->cObj->cObjGetSingle('IMAGE', $imageConf);

            // Get image orientation
            switch ($this->settings['mfpOption']['file_orient']) {
                case 1:
                    $viewAssign['imageorient'] = 'right';
                    break;
                case 2:
                    $viewAssign['imageorient'] = 'left';
                    break;
                case 0:
                default:
                    $viewAssign['imageorient'] = 'center';
            }
            // Get image description/caption
            $viewAssign['imagecaption'] = $file->getProperty('description');

            // Render typolink
            $viewAssign['tsLink'] = $this->cObj->typoLink($theImgCode, $lConf);
        } else {
            $this->addFlashMessage('Please select an image', 'No image', AbstractMessage::WARNING);
        }

        return $viewAssign;
    }

    /**
     * Get settings from flexform
     * If something else than the default from setup is selected or a value is empty use setting from flexform
     *
     * @param string $forType
     * @return void
     */
    protected function getSettingsFromFlexform($forType)
    {
        foreach ($this->settings['mfpOption'] as $key => $value) {
            if ($value != -1 && !empty($value)) {
                $this->settings['type'][$forType][$key] = $value == 'local' ? $this->settings['mfpOption'][$key . '_local'] : $value;
            }
        }
    }
}
