<?php

namespace JonathanHeilmann\JhMagnificpopup\ViewHelpers\InlineContent;

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 * This file is based on the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Base class: InlineContent ViewHelpers
 */
abstract class AbstractInlineContentViewHelper extends AbstractViewHelper
{

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $contentObject;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @return void
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
        $this->contentObject = $configurationManager->getContentObject();
    }

    /**
     * Initialize
     */
    public function initializeArguments()
    {
        $this->registerArgument(
            'hideUntranslated',
            'boolean',
            'If FALSE, will NOT include elements which have NOT been translated, if current language is NOT the ' .
            'default language. Default is to show untranslated elements but never display the original if there is ' .
            'a translated version',
            false,
            false
        );
    }

    /**
     * @param array $queryConfiguration
     * @return array[]
     */
    protected function getRecords(array $queryConfiguration)
    {
        $records = $GLOBALS['TSFE']->cObj->getRecords('tt_content', $queryConfiguration);
        return $records;
    }

    /**
     * This function renders an array of tt_content record into an array of rendered content
     * it returns a list of elements rendered by typoscript RECORD function
     *
     * @param array $rows database rows of records (each item is a tt_content table record)
     * @return array
     */
    protected function getRenderedRecords(array $rows)
    {
        if ($rows === null || count($rows) === 0) {
            return [];
        }

        $elements = [];
        foreach ($rows as $row) {
            array_push($elements, static::renderRecord($row));
        }
        return $elements;
    }

    /**
     * This function renders a raw tt_content record into the corresponding
     * element by typoscript RENDER function. We keep track of already
     * rendered records to avoid rendering the same record twice inside the
     * same nested stack of content elements.
     *
     * @param array $row
     * @return string|NULL
     */
    protected static function renderRecord(array $row)
    {
        if ($row === null || count($row) === 0) {
            return '';
        }

        if (0 < $GLOBALS['TSFE']->recordRegister['tt_content:' . $row['uid']]) {
            return null;
        }
        $conf = [
            'tables' => 'tt_content',
            'source' => $row['uid'],
            'dontCheckPid' => 1
        ];
        $parent = $GLOBALS['TSFE']->currentRecord;
        // If the currentRecord is set, we register, that this record has invoked this function.
        // It's should not be allowed to do this again then!!
        if (false === empty($parent)) {
            ++$GLOBALS['TSFE']->recordRegister[$parent];
        }
        $html = $GLOBALS['TSFE']->cObj->cObjGetSingle('RECORDS', $conf);

        $GLOBALS['TSFE']->currentRecord = $parent;
        if (false === empty($parent)) {
            --$GLOBALS['TSFE']->recordRegister[$parent];
        }
        return $html;
    }

}
