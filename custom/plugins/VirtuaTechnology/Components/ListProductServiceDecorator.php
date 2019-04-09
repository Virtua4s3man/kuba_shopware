<?php

namespace VirtuaTechnology\Components;

use Shopware\Bundle\StoreFrontBundle\Service\Core\ListProductService;
use Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ProductContextInterface;

//todo tu skonczylem
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
        // TODO: Implement getList() method.
    }

    public function get($number, ProductContextInterface $context)
    {
        // TODO: Implement get() method.
    }
}