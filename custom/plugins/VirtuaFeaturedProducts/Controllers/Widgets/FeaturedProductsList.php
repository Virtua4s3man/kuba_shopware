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

        $numbers = $this->getFeaturedProductNumbers();
        $context = $this->container->get('shopware_storefront.context_service')->getShopContext();

        $featuredProducts = $this->container->get('shopware_storefront.list_product_service')
            ->getList($numbers, $context);



        dump($config);
    }

    /**
     * Gets featured product numbers
     *
     * @return array
     */
    private function getFeaturedProductNumbers($number = 3)
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
            ->setMaxResults($number);

        return $builder->execute()->fetchAll(\PDO::FETCH_COLUMN);
    }

}