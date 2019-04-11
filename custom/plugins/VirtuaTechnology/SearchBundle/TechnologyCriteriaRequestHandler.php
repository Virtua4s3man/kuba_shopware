<?php
/**
 * User: virtua
 * Date: 2019-04-04
 * Time: 15:55
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

namespace VirtuaTechnology\SearchBundle;

use Enlight_Controller_Request_RequestHttp as Request;
use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\CriteriaRequestHandlerInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use VirtuaTechnology\SearchBundle\Condition\TechnologyCondition;
use VirtuaTechnology\SearchBundle\Facet\TechnologyFacet;

/**
 * Class TechnologyCriteriaRequestHandler
 */
class TechnologyCriteriaRequestHandler implements CriteriaRequestHandlerInterface
{
    /**
     * @inheritdoc
     */
    public function handleRequest(
        Request $request,
        Criteria $criteria,
        ShopContextInterface $context
    ) {
        $criteria->addFacet(new TechnologyFacet());

        $technology = $request->getParam('technologies', '');
        if ($this->validateTechnologyParameters($technology)) {
            $criteria->addCondition(new TechnologyCondition($technology));
        }
    }

    /**
     * @param $str
     * @return bool
     */
    private function validateTechnologyParameters($str)
    {
        return (bool) preg_match('/^\d+$/', str_replace('|', '', $str));
    }
}
