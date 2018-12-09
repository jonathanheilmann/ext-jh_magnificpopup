<?php
namespace JonathanHeilmann\JhMagnificpopup\ViewHelpers\PageRenderer;

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Class AddJsInlineCodeViewHelper
 * @package JonathanHeilmann\JhMagnificpopup\ViewHelpers\PageRenderer
 */
class AddJsInlineCodeViewHelper extends AbstractPageRenderViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('name', 'string', 'The name of the file', true, null);
        $this->registerArgument('block', 'string', 'The JS content', false, null);
        $this->registerArgument('compress', 'boolean', 'Compress output', false, false);
        $this->registerArgument('forceOnTop', 'boolean', 'Force to top?', false, false);
        $this->registerArgument('addToFooter', 'boolean', 'Add to footer?', false, false);
    }

    public function render()
    {
        if ($this->arguments['block'] === null) $this->arguments['block'] = htmlspecialchars_decode($this->renderChildren(), ENT_QUOTES);

        if ($this->arguments['addToFooter'] === false) {
            $this->pageRenderer->addJsInlineCode($this->arguments['name'], $this->arguments['block'], $this->arguments['compress'], $this->arguments['forceOnTop']);
        } else {
            $this->pageRenderer->addJsFooterInlineCode($this->arguments['name'], $this->arguments['block'], $this->arguments['compress'], $this->arguments['forceOnTop']);
        }
        return '';
    }
}