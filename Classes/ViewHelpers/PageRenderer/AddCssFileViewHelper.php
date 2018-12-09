<?php
namespace JonathanHeilmann\JhMagnificpopup\ViewHelpers\PageRenderer;

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Class AddCssFileViewHelper
 * @package JonathanHeilmann\JhMagnificpopup\ViewHelpers\PageRenderer
 */
class AddCssFileViewHelper extends AbstractPageRenderViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('file', 'string', 'The name of the file', true, null);
        $this->registerArgument('rel', 'string', 'Rel', false, 'stylesheet');
        $this->registerArgument('media', 'string', 'Media', false, 'all');
        $this->registerArgument('title', 'string', 'Title', false, '');
        $this->registerArgument('compress', 'boolean', 'Compress output?', false, true);
        $this->registerArgument('forceOnTop', 'boolean', 'Force to top?', false, false);
        $this->registerArgument('allWrap', 'string', 'Wrap', false, '');
        $this->registerArgument('excludeFromConcatenation', 'boolean', 'Exclude from concatenation', false, false);
        $this->registerArgument('splitChar', 'string', 'Split character', false, '|');
    }

    /**
     * @see PageRenderer::addJsFile
     * @see PageRenderer::addJsFooterFile
     */
    public function render()
    {
        $file = $GLOBALS['TSFE']->tmpl->getFileName($this->arguments['file']);
        $this->pageRenderer->addCssFile(
            $file,
            $this->arguments['rel'],
            $this->arguments['media'],
            $this->arguments['title'],
            $this->arguments['compress'],
            $this->arguments['forceOnTop'],
            $this->arguments['allWrap'],
            $this->arguments['excludeFromConcatenation'],
            $this->arguments['splitChar']
        );
    }

}