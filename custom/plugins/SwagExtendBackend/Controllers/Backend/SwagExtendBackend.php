<?php

use Doctrine\DBAL\Connection;
use Shopware\Components\Model\QueryBuilder;
use Shopware\Models\Article\Article;

class Shopware_Controllers_Backend_SwagExtendBackend extends Shopware_Controllers_Backend_Application
{
    protected $model = Article::class;

    protected $alias = 'product';

    /**
     * {@inheritdoc}
     */
    protected function getListQuery()
    {
        $customerId = $this->Request()->getParam('customerId');

        $sql = '
            SELECT DISTINCT articleID
            FROM s_order_details details
                INNER JOIN s_order ON s_order.id = details.orderID
            WHERE s_order.userID = :customerId
            AND articleID > 0;';

        /** @var Connection $dbConnection */
        $dbConnection = $this->get('dbal_connection');

        $ids = $dbConnection->executeQuery($sql, ['customerId' => $customerId])
            ->fetchAll(PDO::FETCH_COLUMN);

        /** @var QueryBuilder $builder */
        $builder = parent::getListQuery();
        $builder->select([
            'product.id',
            'product.mainDetailId',
            'product.name',
        ]);
        $builder->andWhere('product.id IN (:productIds)')
            ->setParameter('productIds', $ids);

        return $builder;
    }
}
