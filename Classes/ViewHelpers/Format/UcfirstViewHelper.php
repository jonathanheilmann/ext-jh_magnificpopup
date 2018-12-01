<?php
namespace JonathanHeilmann\JhMagnificpopup\ViewHelpers\Format;

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class AddJsInlineCodeViewHelper
 * @package JonathanHeilmann\JhMagnificpopup\ViewHelpers\PageRenderer
 */
class UcfirstViewHelper extends AbstractViewHelper
{

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'string',
            'string',
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
        if ($arguments['string'] === null) {
            $arguments['string'] = $renderChildrenClosure();
        }

        return ucfirst($arguments['string']);
    }

}