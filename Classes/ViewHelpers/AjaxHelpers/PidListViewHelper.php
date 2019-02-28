<?php
namespace JonathanHeilmann\JhMagnificpopup\ViewHelpers\AjaxHelpers;

/*
 * This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 * This file is based on the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Doctrine\DBAL\Driver\Statement;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;


/**
 * ViewHelper used to return a pid list of tt_content uids
 */
class PidListViewHelper extends AbstractViewHelper
{

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'uidList',
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
        if ('BE' === TYPO3_MODE) {
            return '';
        }

        $uidArray = explode(',', $arguments['uidList']);
        $pidInList = [];
        foreach ($uidArray as $uid) {
            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
            /** @var Statement $statement */
            $statement = $queryBuilder
                ->select('pid')
                ->from('tt_content')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
                )
                ->execute();
            if ($firstCol = $statement->fetchColumn()) {
                $pidInList[] = $firstCol;
            }
        }
        return implode(',', $pidInList);
    }
}
