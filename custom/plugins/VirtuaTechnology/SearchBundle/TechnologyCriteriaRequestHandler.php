<?php

namespace VirtuaTechnology\SearchBundle;

use Enlight_Controller_Request_RequestHttp as Request;
use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\CriteriaRequestHandlerInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use VirtuaTechnology\SearchBundle\Condition\TechnologyCondition;
use VirtuaTechnology\SearchBundle\Facet\TechnologyFacet;

class TechnologyCriteriaRequestHandler implements CriteriaRequestHandlerInterface
{
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

    private function validateTechnologyParameters($str)
    {
        return (bool) preg_match('/^\d+$/', str_replace('|', '', $str));
    }
}
