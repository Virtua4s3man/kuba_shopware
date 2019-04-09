<?php
/**
 * Created by PhpStorm.
 * User: virtua
 * Date: 2019-04-05
 * Time: 10:56
 */

namespace VirtuaTechnology\SearchBundleDBAL\Condition;

use Doctrine\Common\Util\Debug;
use Shopware\Bundle\SearchBundle\ConditionInterface;
use Shopware\Bundle\SearchBundleDBAL\ConditionHandlerInterface;
use Shopware\Bundle\SearchBundleDBAL\QueryBuilder;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use VirtuaTechnology\SearchBundle\Condition\TechnologyCondition;

class TechnologyConditionHandler implements ConditionHandlerInterface
{
    /**
     * @inheritdoc
     */
    public function supportsCondition(ConditionInterface $condition)
    {
        return ($condition instanceof TechnologyCondition);
    }

    /**
     * @inheritdoc
     */
    public function generateCondition(
        ConditionInterface $condition,
        QueryBuilder $query,
        ShopContextInterface $context
    ) {
        $query->andWhere('productAttribute.technology REGEXP :id')
            ->setParameter(
                'id',
                $this->makeIdStringRegex($condition->getTechnologies()),
                \PDO::PARAM_STR
            );
    }

    /**
     * Make regexp searching for patter
     * @param $string
     * @example '1|2|3'
     *
     * @return string
     * @example '|1|2|3|'
     * @example ''
     */
    private function makeIdStringRegex($string)
    {
        return $this->validateMultiselectIdString($string) ?
            '\|' . str_replace('|', '\|', $string) . '\|'
            : '';
    }

    /**
     * Checks if all id's in string are integers
     *
     * @param $string
     *
     * @return bool
     */
    private function validateMultiselectIdString($string)
    {
        $ids = explode('|', $string);
        foreach ($ids as $id) {
            if (!is_numeric($id)) {
                return false;
            }
        }

        return true;
    }
}