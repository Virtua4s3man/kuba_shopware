<?php

namespace VirtuaTechnology\Components;

use Doctrine\Common\Util\Debug;
use Shopware\Bundle\StoreFrontBundle\Service\Core\ListProductService;
use Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ProductContextInterface;

//todo usunąć prawdopodobnie
class ListProductServiceDecorator implements ListProductServiceInterface
{
    private $coreService;

    private $technologyService;

    public function __construct(ListProductService $listService, TechnologyService $technologyService)
    {
        $this->coreService = $listService;
        $this->technologyService = $technologyService;
    }

    public function getList(array $numbers, ProductContextInterface $context)
    {
        $products = $this->coreService->getList($numbers, $context);

        foreach ($products as $product) {
            $this->technologyService->findTechnologiesByIds('');
        }
//        todo usunac
//        error_log(Debug::dump('wyk1\n'), 3, Shopware()->DocPath() . '/debug.log' );

        return $products;
    }

    public function get($number, ProductContextInterface $context)
    {
        return array_shift(
            $this->getList([$number], $context)
        );
    }
}