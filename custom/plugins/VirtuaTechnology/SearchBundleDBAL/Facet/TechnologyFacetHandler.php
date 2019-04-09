<?php

namespace VirtuaTechnology\SearchBundleDBAL\Facet;

use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\FacetInterface;
use Shopware\Bundle\SearchBundle\FacetResult\ValueListFacetResult;
use Shopware\Bundle\SearchBundle\FacetResult\ValueListItem;
use Shopware\Bundle\SearchBundleDBAL\PartialFacetHandlerInterface;
use Shopware\Bundle\SearchBundleDBAL\QueryBuilder;
use Shopware\Bundle\SearchBundleDBAL\QueryBuilderFactory;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use VirtuaTechnology\SearchBundle\Facet\TechnologyFacet;

class TechnologyFacetHandler implements PartialFacetHandlerInterface
{
    private $queryBuilderFactory;

    public function __construct(QueryBuilderFactory $queryBuilderFactory)
    {
        $this->queryBuilderFactory = $queryBuilderFactory;
    }

    public function supportsFacet(FacetInterface $facet)
    {
        return ($facet instanceof TechnologyFacet);
    }

    public function generatePartialFacet(
        FacetInterface $facet,
        Criteria $reverted,
        Criteria $criteria,
        ShopContextInterface $context
    ) {

        return new ValueListFacetResult(
            $facet->getName(),
            $criteria->hasCondition($facet->getName()),
            'Technologies',
            $this->createListItems(
                $this->queryBuilderFactory->createQueryBuilder(),
                $criteria
            ),
            'technologies'
        );
    }

    /**
     * @param QueryBuilder $builder
     *
     * @return array
     */
    private function createListItems(QueryBuilder $builder)
    {
        $listItems = [];
        $technologies = $builder->select('id', 'name')
            ->from('virtua_technology', 'technology')
            ->execute()->fetchAll(\PDO::FETCH_KEY_PAIR);

        foreach ($technologies as $id => $name) {
            $listItem = new ValueListItem(
                $id,
                $name,
                false
            );

            $listItems[] = $listItem;
        }

        return $listItems;
    }
}