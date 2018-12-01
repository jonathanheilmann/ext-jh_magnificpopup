<?php
namespace JonathanHeilmann\JhMagnificpopup\ViewHelpers\InlineContent;

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 * This file is based on the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;


/**
 * ViewHelper used to render inline content elements in Fluid templates
 */
class InlineViewHelper extends AbstractInlineContentViewHelper
{

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'data',
            'array',
            ''
        );
    }

    /**
     * Render method
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        if ('BE' === TYPO3_MODE) {
            return '';
        }

        // Get records
        $records =InlineViewHelper::getRecords([
            'where' => 'tx_jhmagnificpopup_irre_parentid=' .
                (isset($arguments['data']['_LOCALIZED_UID'])
                    ? $arguments['data']['_LOCALIZED_UID']
                    : $arguments['data']['uid']
                ),
            'pidInList' => 'this',
            'includeRecordsWithoutDefaultTranslation' => !$arguments['hideUntranslated'],
            'orderBy' => 'sorting'
        ]);
        if (empty($records)) {
            return '';
        }

        // Render records
        $renderedRecords = InlineViewHelper::getRenderedRecords($records);

        $content = implode(LF, $renderedRecords);
        return $content;
    }
}
