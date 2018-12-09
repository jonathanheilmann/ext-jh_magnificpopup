<?php
namespace JonathanHeilmann\JhMagnificpopup\ViewHelpers\PageRenderer;

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Class AddJsFileViewHelper
 * @package JonathanHeilmann\JhMagnificpopup\ViewHelpers\PageRenderer
 */
class AddJsFileViewHelper extends AbstractPageRenderViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('file', 'string', 'The name of the file', true, null);
        $this->registerArgument('type', 'string', 'Type', false, 'text/javascript');
        $this->registerArgument('compress', 'boolean', 'Compress output?', false, true);
        $this->registerArgument('forceOnTop', 'boolean', 'Force to top?', false, false);
        $this->registerArgument('allWrap', 'string', 'Wrap', false, '');
        $this->registerArgument('excludeFromConcatenation', 'boolean', 'Exclude from concatenation', false, false);
        $this->registerArgument('splitChar', 'string', 'Split character', false, '|');
        $this->registerArgument('async', 'boolean', 'Async', false, false);
        $this->registerArgument('integrity', 'string', 'Integrity', false, '');
        $this->registerArgument('addToFooter', 'string', 'Add to footer?', false, false);
    }

    /**
     * @see PageRenderer::addJsFile
     * @see PageRenderer::addJsFooterFile
     */
    public function render()
    {
        $file = $GLOBALS['TSFE']->tmpl->getFileName($this->arguments['file']);
        if ($this->arguments['addToFooter'] === false) {
            $this->pageRenderer->addJsFile($file, $this->arguments['type'], $this->arguments['compress'],
                $this->arguments['forceOnTop'], $this->arguments['allWrap'],
                $this->arguments['excludeFromConcatenation'], $this->arguments['splitChar'], $this->arguments['async'],
                $this->arguments['integrity']);
        } else {
            $this->pageRenderer->addJsFooterFile($file, $this->arguments['type'], $this->arguments['compress'], $this->arguments['forceOnTop'], $this->arguments['allWrap'], $this->arguments['excludeFromConcatenation'], $this->arguments['splitChar'], $this->arguments['async'], $this->arguments['integrity']);
        }
    }

}