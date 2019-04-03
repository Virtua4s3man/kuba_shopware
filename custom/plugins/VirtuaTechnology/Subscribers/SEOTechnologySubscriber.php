<?php

namespace VirtuaTechnology\Subscribers;

use Doctrine\ORM\QueryBuilder;
use Enlight\Event\SubscriberInterface;

class SEOTechnologySubscriber implements SubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_RefreshSeoIndex_CreateRewriteTable' => 'createTechnologyRewriteTable',
            'sRewriteTable::sCreateRewriteTable::after' => 'createTechnologyRewriteTable',
        ];
    }

    public function createTechnologyRewriteTable()
    {
        /** @var \sRewriteTable $rewriteTableModule */
        $rewriteTableModule = Shopware()->Container()->get('modules')->sRewriteTable();

        /** @var QueryBuilder $builder */
        $builder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $urls = $builder->select('technology.id, technology.url')
            ->from('virtua_technology', 'technology')
            ->execute()
            ->fetchAll(\PDO::FETCH_KEY_PAIR);

        foreach ($urls as $id => $url) {
            $rewriteTableModule->sInsertUrl(
                'sViewport=technology&sAction=detail&technologyId=' . $id,
                'technology/' . $url
            );
        }
    }
}
