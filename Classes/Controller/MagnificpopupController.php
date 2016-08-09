<?php
namespace Heilmann\JhMagnificpopup\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2016 Jonathan Heilmann <mail@jonathan-heilmann.de>
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
        $localizedRecord = $this->pageRepository->getRecordOverlay('tt_content', $this->data, $GLOBALS['TSFE']->sys_language_uid, $GLOBALS['TSFE']->sys_language_mode);
        if ($localizedRecord !== false && isset($localizedRecord['_LOCALIZED_UID']))
            $this->data = $localizedRecord;

        $viewAssign['uid'] = $this->data['uid'];

        switch ($this->settings['contenttype']) {
            case 'iframe':
                $viewAssign = GeneralUtility::array_merge($viewAssign, $this->iframe());
                break;
            case 'reference':
            case 'inline':
                if (($this->settings['content']['procedure_reference'] == 'ajax' && !empty($this->settings['contenttype'])) || $this->settings['content']['procedure_inline'] == 'ajax') {
                    $viewAssign = GeneralUtility::array_merge($viewAssign, $this->ajax());
                } elseif (($this->settings['content']['procedure_reference'] && !empty($this->settings['contenttype'])) == 'inline' || $this->settings['content']['procedure_inline'] == 'inline') {
                    $viewAssign = GeneralUtility::array_merge($viewAssign, $this->inline());
                } elseif ($this->settings['content']['procedure_reference'] == '' && $this->settings['content']['procedure_inline'] == '') {
                    // Add error if no method (inline or ajax) has been selected
                    $this->addFlashMessage('Please select the method (inline or ajax) to display Magnific Popup content', 'Select method', AbstractMessage::WARNING);
                } elseif ($this->settings['content']['procedure_reference'] != '' && empty($this->settings['contenttype'])) {
                    // Add error if no content has been selected
                    $this->addFlashMessage('Please select a content to display with Magnific Popup', 'Select content', AbstractMessage::WARNING);
                }
                break;
            default:
                // Add error if no "Display type" has been selected
                $this->addFlashMessage('Please select a "Display type" to use Magnific Popup', 'Select "Display type"', AbstractMessage::WARNING);
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
            $uidList = $this->settings['content']['reference'];
            $uidArray = explode(',', $uidList);
            $pidInList = array();
            foreach ($uidArray as $uid) {
                $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('pid', 'tt_content', 'uid='.$uid);
                $pidInList[] = $row['pid'];
            }
            // Configure the link
            $linkconf = array();
            $linkconf['parameter'] = $this->data['pid'];
            if ($this->settings['useEidForAjaxMethod'] != 1) {
                $linkconf['additionalParams'] = '&type=109&jh_magnificpopup[type]=reference&jh_magnificpopup[uid]='.$this->settings['content']['reference'].'&jh_magnificpopup[pid]='.implode(',', $pidInList);
            } else {
                $linkconf['additionalParams'] = '&eID=jh_magnificpopup_ajax&jh_magnificpopup[type]=reference&jh_magnificpopup[uid]='.$this->settings['content']['reference'].'&jh_magnificpopup[pid]='.implode(',', $pidInList);
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
        $lConf = array();
        $lConf['ATagParams'] = 'class="mfp-ajax-'.$this->data['uid'].'"';
        $lConf['parameter'] = $linkconf['parameter'];
        $lConf['additionalParams'] = $linkconf['additionalParams'];
        // Support old way of link-setup. Will be removed later!
        $viewAssign['link-class'] = 'mfp-ajax-'.$this->data['uid'];
        $viewAssign['link'] = $this->cObj->typolink_URL($linkconf);
        $viewAssign['link-text'] = $this->settings['mfpOption']['text'];

        if ($this->settings['linktype'] == 'file') {
            ArrayUtility::mergeRecursiveWithOverrule($viewAssign, $this->renderLinktypeFile($lConf));
        } else {
            $viewAssign['tsLink'] = $this->cObj->typolink($this->settings['mfpOption']['text'], $lConf);
        }

        // Get settings from flexform
        // If something else than the default from setup is selected or a value is empty use setting from flexform
        foreach ($this->settings['mfpOption'] as $key => $value) {
            if ($value != -1 && !empty($value)) {
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

    /**
     * @return array
     */
    protected function inline()
    {
        $viewAssign['type'] = 'inline';
        // Use inline procedure
        // Render irre content as inline-htmlcode
        if ($this->settings['contenttype'] == 'reference') {
            //get list of pid's
            $uidList = $this->settings['content']['reference'];
            $uidArray = explode(',', $uidList);
            $pidInList = array();
            foreach ($uidArray as $uid) {
                $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('pid', 'tt_content', 'uid='.$uid);
                $pidInList[] = $row['pid'];
            }
            // Configure the content
            $irre_conf = array(
                'table'    => 'tt_content',
                'select.'    => array(
                    'where' => 'tt_content.uid IN('.$this->settings['content']['reference'].')',
                    'languageField' => 'sys_language_uid',
                    'pidInList' => implode(',', $pidInList),
                    'orderBy' => 'sorting'
                )
            );
        } else {
            // Configure the content
            $irre_conf = array(
                'table'    => 'tt_content',
                'select.'    => array(
                    'where' => 'tx_jhmagnificpopup_irre_parentid=' . (isset($this->data['_LOCALIZED_UID']) ? $this->data['_LOCALIZED_UID'] : $this->data['uid']) . $this->pageRepository->enableFields('tt_content'),
                    'languageField' => '0',
                    //'includeRecordsWithoutDefaultTranslation' => 1,
                    'orderBy' => 'sorting'
                )
            );
        }
        // Render inlinecontent
        $viewAssign['inlinecontent'] = $this->cObj->CONTENT($irre_conf);
        $viewAssign['inlinecontent_id'] = 'mfp-inline-'.$this->data['uid'];

        // Link-setup
        $lConf = array();
        $lConf['ATagParams'] = 'class="mfp-inline-'.$this->data['uid'].'" data-mfp-src="#mfp-inline-'.$this->data['uid'].'"';
        $lConf['parameter'] = $GLOBALS['TSFE']->id;
        // Support old way of link-setup. Will be removed later!
        $viewAssign['link-class'] = 'mfp-inline-'.$this->data['uid'];
        $viewAssign['link'] = '#mfp-inline-'.$this->data['uid'];
        $viewAssign['link-text'] = $this->settings['mfpOption']['text'];

        if ($this->settings['linktype'] == 'file') {
            ArrayUtility::mergeRecursiveWithOverrule($viewAssign, $this->renderLinktypeFile($lConf));
        } else {
            $viewAssign['tsLink'] = $this->cObj->typolink($this->settings['mfpOption']['text'], $lConf);
        }

        // Get settings from flexform
        // If something else than the default from setup is selected or a value is empty use setting from flexform
        foreach ($this->settings['mfpOption'] as $key => $value) {
            if ($value != -1 && !empty($value)) {
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

    /**
     * @return array
     */
    protected function iframe()
    {
        $viewAssign['type'] = 'iframe';

        // Link-setup
        $lConf = $this->configureLink($selectorClass = 'mfp-iframe-'.$this->data['uid']);
        // Support old way of link-setup. Will be removed later!
        $parameters = GeneralUtility::unQuoteFilenames($this->settings['mfpOption']['href'], true);
        if (count($parameters) == 1) {
            $viewAssign['link-class'] = 'mfp-iframe-'.$this->data['uid'];
            $viewAssign['link'] = $this->settings['mfpOption']['href'];
            $viewAssign['link-text'] = $this->settings['mfpOption']['text'];
        }

        if ($this->settings['linktype'] == 'file') {
            ArrayUtility::mergeRecursiveWithOverrule($viewAssign, $this->renderLinktypeFile($lConf));
        } else {
            $viewAssign['tsLink'] = $this->cObj->typolink($this->settings['mfpOption']['text'], $lConf);
        }

        // Get settings from flexform
        // If something else than the default from setup is selected or a value is empty use setting from flexform
        foreach ($this->settings['mfpOption'] as $key => $value) {
            if ($value != -1 && !empty($value)) {
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
        /** @var \TYPO3\CMS\Core\Resource\FileRepository $fileRepository */
        $fileRepository = $this->objectManager->get('TYPO3\\CMS\\Core\\Resource\\FileRepository');
        $fileObjects = $fileRepository->findByRelation('tt_content', 'mfp_image', isset($this->data['_LOCALIZED_UID']) ? $this->data['_LOCALIZED_UID'] : $this->data['uid']);

        if (!empty($fileObjects)) {
            /** @var \TYPO3\CMS\Core\Resource\FileReference $file */
            $file = $fileObjects[0];
            $this->cObj->setCurrentFile($file->getOriginalFile());
            $imageConf = $GLOBALS['TSFE']->tmpl->setup['lib.']['tx_jhmagnificpopup_pi1.']['image.'];
            $imageConf['file.']['treatIdAsReference'] = 1;
            $imageConf['file'] = $file;
            if (!empty($this->settings['mfpOption']['file_width'])) {
                $imageConf["file."]["maxW"] = $this->settings['mfpOption']['file_width'];
            }
            if (!empty($this->settings['mfpOption']['file_height'])) {
                $imageConf["file."]["maxH"] = $this->settings['mfpOption']['file_height'];
            }
            // Render image
            $theImgCode = $this->cObj->IMAGE($imageConf);

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
            $viewAssign['tsLink'] = $this->cObj->typolink($theImgCode, $lConf);
        } else {
            $this->addFlashMessage('Please select an image', 'No image', AbstractMessage::WARNING);
        }
        return $viewAssign;
    }
}
