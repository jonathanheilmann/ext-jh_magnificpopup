<?php
namespace JonathanHeilmann\JhMagnificpopup\ViewHelpers\PageRenderer;

use TYPO3\CMS\Core\Page\PageRenderer;

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
class AddJsInlineCodeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @param string $name
     * @param string|null $block
     * @param bool $compress
     * @param bool $forceOnTop
     * @param bool $addToFooter
     */
    public function render($name, $block = null, $compress = true, $forceOnTop = false, $addToFooter = false)
    {
        if ($block === null) $block = $this->renderChildren();

        /** @var PageRenderer $pageRenderer */
        $pageRenderer = $this->objectManager->get(PageRenderer::class);
        if ($addToFooter === false)
        {
            $pageRenderer->addJsInlineCode($name, $block, $compress, $forceOnTop);
        } else{
            $pageRenderer->addJsFooterInlineCode($name, $block, $compress, $forceOnTop);
        }
    }

}