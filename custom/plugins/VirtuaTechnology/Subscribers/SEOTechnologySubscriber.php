<?php
/**
 * User: virtua
 * Date: 2019-04-04
 * Time: 15:55
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

namespace VirtuaTechnology\Subscribers;

use Doctrine\ORM\QueryBuilder;
use Enlight\Event\SubscriberInterface;

/**
 * Class SEOTechnologySubscriber
 */
class SEOTechnologySubscriber implements SubscriberInterface
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_RefreshSeoIndex_CreateRewriteTable' => 'createTechnologyRewriteTable',
            'sRewriteTable::sCreateRewriteTable::after' => 'createTechnologyRewriteTable',
            'Shopware_Controllers_Seo_filterCounts' => 'addTechnologyCount',
            'Shopware_Components_RewriteGenerator_FilterQuery' => 'filterParameterQuery'
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     * @return mixed
     */
    public function addTechnologyCount(\Enlight_Event_EventArgs $args)
    {
        $counts = $args->getReturn();

        /** @var QueryBuilder $dbalQueryBuilder */
        $dbalQueryBuilder = $this->container->get('dbal_connection')->createQueryBuilder();
        $technologyCount = $dbalQueryBuilder->select('COUNT(technology.id)')
            ->from('virtua_technology', 'technology')
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);

        $counts['technologies'] = $technologyCount;

        return $counts;
    }

    /**
     * Rewrite query parameters for seo url-s
     *
     * @param \Enlight_Event_EventArgs $args
     * @return mixed
     */
    public function filterParameterQuery(\Enlight_Event_EventArgs $args)
    {
        $orgQuery = $args->getReturn();
        $query = $args->getQuery();

        if ($query['controller'] === 'technologies' && isset($query['technologyId'])) {
            $orgQuery['technologyId'] = $query['technologyId'];
        }

        return $orgQuery;
    }

    /**
     * Persist seo url-s for technologies
     */
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
                'sViewport=technologies&sAction=detail&technologyId=' . $id,
                'technologies/' . $url
            );
        }
    }
}
