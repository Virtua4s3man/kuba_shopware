<?php
/**
 * User: virtua
 * Date: 2019-04-04
 * Time: 15:55
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

namespace VirtuaTechnology\SearchBundleDBAL\Condition;

use Shopware\Bundle\SearchBundle\ConditionInterface;
use Shopware\Bundle\SearchBundleDBAL\ConditionHandlerInterface;
use Shopware\Bundle\SearchBundleDBAL\QueryBuilder;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use VirtuaTechnology\SearchBundle\Condition\TechnologyCondition;

/**
 * Class TechnologyConditionHandler
 */
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
        $ids = array_map(
            'intval',
            explode('|', $condition->getTechnologies())
        );

        foreach ($ids as $id) {
            if (is_int($id)) {
                $query->andWhere('productAttribute.technology REGEXP :id')
                    ->setParameter(
                        'id',
                        '\|' . $id . '\|',
                        \PDO::PARAM_STR
                    );
            }
        }
    }
}
