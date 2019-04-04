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
            'Shopware_Controllers_Seo_filterCounts' => 'addTechnologyCount',
            'Shopware_Components_RewriteGenerator_FilterQuery' => 'filterParameterQuery'
        ];
    }

    public function addTechnologyCount(\Enlight_Event_EventArgs $args)
    {
        $counts = $args->getReturn();

        /** @var QueryBuilder $dbalQueryBuilder */
        $dbalQueryBuilder = $this->container->get('dbal_connection')->createQueryBuilder();
        $technologyCount = $dbalQueryBuilder->select('COUNT(technology.id)')
            ->from('virtua_technology', 'technology')
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);

        $counts['technology'] = $technologyCount;

        return $counts;
    }

    public function filterParameterQuery(\Enlight_Event_EventArgs $args)
    {
        $orgQuery = $args->getReturn();
        $query = $args->getQuery();

        if ($query['controller'] === 'technology' && isset($query['technologyId'])) {
            $orgQuery['technologyId'] = $query['technologyId'];
        }

        return $orgQuery;
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
