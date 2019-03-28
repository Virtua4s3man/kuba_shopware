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
    /**
     * Provide data to featured products slider widget
     */
    public function customAction()
    {
        $config = $this->container->get('virtua_featured_products.config');
        $this->View()->assign('display', $config['display']);

        //todo pytanie jak zwrócić pusty widok?
        if ($config['display'] === false) {
            return;
        }

        //todo co zrobic z tym max result
        $orderNumbers = $this->getFeaturedProductNumbers($config['product_count']);
        $productStruct = $this->getFeaturedProductStructList($orderNumbers);


        //todo problem z produktami sw10176 sw10164
        dump($orderNumbers);
        dump($productStruct);

        $this->View()->assign(
            'featuredProducts',
            $productStruct
        );
    }

    /**
     * Fetchs featured product, order numbers
     *
     * @param $maxResults how many order numbers are fetched
     *
     * @return array
     */
    private function getFeaturedProductNumbers($maxResults)
    {
        //todo nie jestem pewien czy to details.kind=1 powinno byc
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
            ->andWhere('details.kind = 1')
            ->setMaxResults($maxResults);

        return $builder->execute()->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Gets array of product arrays
     *
     * @param array $orderNumbers
     * @return array
     */
    private function getFeaturedProductStructList(array $orderNumbers)
    {
        $context = $this->container->get('shopware_storefront.context_service')
            ->getShopContext();
        $productList = $this->container->get('shopware_storefront.list_product_service')
            ->getList($orderNumbers, $context);

        return $this->container->get('legacy_struct_converter')
            ->convertListProductStructList($productList);
    }
}
