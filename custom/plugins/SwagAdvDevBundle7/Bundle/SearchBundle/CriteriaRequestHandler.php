<?php

namespace SwagAdvDevBundle7\Bundle\SearchBundle;

use Enlight_Controller_Request_RequestHttp as Request;
use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\CriteriaRequestHandlerInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use SwagAdvDevBundle7\Bundle\SearchBundle\Condition\BundleCondition;
use SwagAdvDevBundle7\Bundle\SearchBundle\Facet\BundleFacet;

class CriteriaRequestHandler implements CriteriaRequestHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handleRequest(
        Request $request,
        Criteria $criteria,
        ShopContextInterface $context
    ) {
        $criteria->addFacet(new BundleFacet());

        if ($request->has('bundle')) {
            $criteria->addCondition(new BundleCondition());
        }
        //todo add bundle facet to criteria
        //todo if request contains your own "bundle" parameter, add bundle condition
    }
}
