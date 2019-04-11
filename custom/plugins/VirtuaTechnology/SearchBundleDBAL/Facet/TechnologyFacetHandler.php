<?php
/**
 * User: virtua
 * Date: 2019-04-04
 * Time: 15:55
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

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

/**
 * Class TechnologyFacetHandler
 */
class TechnologyFacetHandler implements PartialFacetHandlerInterface
{
    /** @var QueryBuilderFactory  */
    private $queryBuilderFactory;

    /**
     * TechnologyFacetHandler constructor.
     * @param QueryBuilderFactory $queryBuilderFactory
     */
    public function __construct(QueryBuilderFactory $queryBuilderFactory)
    {
        $this->queryBuilderFactory = $queryBuilderFactory;
    }

    /**
     * @inheritdoc
     */
    public function supportsFacet(FacetInterface $facet)
    {
        return ($facet instanceof TechnologyFacet);
    }

    /**
     * @inheritdoc
     */
    public function generatePartialFacet(
        FacetInterface $facet,
        Criteria $reverted,
        Criteria $criteria,
        ShopContextInterface $context
    ) {

        if (!$this->technologyAttributeFound($reverted, $context)) {
            return null;
        }

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

    /**
     * Check if there is product with technology attribute
     * @param Criteria $reverted
     * @param ShopContextInterface $context
     *
     * @return bool
     * @throws \Exception
     */
    private function technologyAttributeFound(Criteria $reverted, ShopContextInterface $context)
    {
        return (bool) $this->queryBuilderFactory->createQuery($reverted, $context)
            ->select('productAttribute.technology')
            ->andWhere('productAttribute.technology IS NOT NULL')
            ->execute()->fetch();
    }
}
