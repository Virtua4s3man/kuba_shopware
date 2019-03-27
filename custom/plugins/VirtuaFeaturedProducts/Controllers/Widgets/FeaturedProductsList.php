<?php
/**
 * User: virtua
 * Date: 2019-03-26
 * Time: 14:38
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @license GNU GPLv3
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

/**
 * Class responsible for adding view templates and variables
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @license GNU GPLv3
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */
class Shopware_Controllers_Widgets_FeaturedProductsList extends \Enlight_Controller_Action
{
    public function customAction()
    {
        $config = $this->container->get('virtua_featured_products.config');

        $this->View()->assign('display', $config['display']);

//        if ($config['display'] === false) {
//            return;
//        }


        $maxResultss = $this->getFeaturedProductNumbers($config['product_count']);
        $context = $this->container->get('shopware_storefront.context_service')->getShopContext();

        //10164
        //10176
        //TS
        // produkty o tych ordernumber nie są pobierane przez getList dlaczego?
        $featuredProducts = $this->container->get('shopware_storefront.list_product_service')
            ->getList($maxResultss, $context);

        dump($maxResultss);
        dump($featuredProducts);
    }

    /**
     * Gets featured product numbers
     *
     * @return array
     */
    private function getFeaturedProductNumbers($maxResults)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $builder = $this->container->get('dbal_connection')->createQueryBuilder();
        $builder->select('details.ordernumber')
            ->from('s_articles_details', 'details')
            ->innerJoin(
                'details',
                's_articles_attributes',
                'attributes',
                'details.articleID = attributes.articleID'
            )->where('attributes.is_featured = 1')
            ->andWhere('details.kind = 1');

        return $builder->execute()->fetchAll(\PDO::FETCH_COLUMN);
    }

}