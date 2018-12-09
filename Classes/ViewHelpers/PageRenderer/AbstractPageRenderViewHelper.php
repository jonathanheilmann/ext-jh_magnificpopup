<?php
namespace JonathanHeilmann\JhMagnificpopup\ViewHelpers\PageRenderer;

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class AbstractPageRenderViewHelper extends AbstractTagBasedViewHelper
{

    /** @var ObjectManager */
    protected $objectManager;

    /** @var PageRenderer */
    protected $pageRenderer;

    public function initialize()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->pageRenderer = $this->objectManager->get(PageRenderer::class);
    }
}
