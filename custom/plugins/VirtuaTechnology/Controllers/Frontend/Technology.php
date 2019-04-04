<?php

class Shopware_Controllers_Frontend_Technology extends Enlight_Controller_Action
{
    public function indexAction()
    {
        $sPage = (int) $this->Request()->getParam('p', 1);
        $perSite = 2;

        $technologiesPaginator = $this->getTechnologiesPaginator($sPage, $perSite);
        $techonologiesArticleStruct = $this->convertTechnologiesToArticleStruct(
            $technologiesPaginator->getIterator()->getArrayCopy()
        );

        /** @var \Shopware\Components\QueryAliasMapper $mapper */
        $mapper = $this->get('query_alias_mapper');
        $this->View()->assign([
            'shortParameters' => $mapper->getQueryAliases(),
            'showListing' => true,
            'sPage' => $sPage,
            'sArticles' => $techonologiesArticleStruct,
            'theme' => ['infiniteScrolling' => false],
        ]);

        //todo pytanie: nie moglem przekaza zmiennej pages do widoku bo byla nadpisywana przez nie wiem co
        //w koncu przekleilem kawalek action-pagination do technology/index.tpl i zmienilem nazwe zmiennej
        //jak to zrobic lepiej?
        $this->View()->assign('t_pages', (int) round($technologiesPaginator->count() / $perSite));
    }

    /**
     * Assign technology data to View
     *
     * @throws Exception
     */
    public function detailAction()
    {
        $id = (int) $this->Request()->getParam('technologyId');

        $technology = $this->getBaseTechnologyQueryBuilder()
            ->where('t.id = :id')
            ->setParameter('id', $id, PDO::PARAM_INT)
            ->getQuery()
            ->setHydrationMode(\Doctrine\ORM\Query::HYDRATE_SCALAR)
            ->execute();

        $this->View()->assign(
            'sArticle',
            array_shift(
                $this->convertTechnologiesToArticleStruct($technology)
            )
        );
    }

    /**
     * Create paginator for fetched technologies
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     * @throws Exception
     */
    private function getTechnologiesPaginator($sPage, $perSite)
    {
        $firstResult = ($sPage-1) * $perSite;
        $query = $this->getBaseTechnologyQueryBuilder($perSite, $firstResult)
            ->setFirstResult($firstResult)
            ->setMaxResults($perSite)
            ->getQuery();
        $query->setHydrationMode(\Doctrine\ORM\Query::HYDRATE_SCALAR);

        return $this->getModelManager()->createPaginator($query);
    }

    /**
     * Convert fetched technologies array to sArticle like structure used on frontend
     *
     * @param array $technologies
     * @return array
     * @throws Exception
     */
    private function convertTechnologiesToArticleStruct(array $technologies)
    {
        /** @var \Shopware\Bundle\MediaBundle\MediaService $mediaService */
        $mediaService = $this->get('shopware_media.media_service');

        $converted = [];
        foreach ($technologies as $technology) {
            $technologyStruct = [];
            $technologyStruct['articleName'] = $technology['t_name'];
            $technologyStruct['linkDetails'] =
                $this->Request()->getPathInfo() . $technology['t_url'];
            $technologyStruct['description_long'] = $technology['t_description'];

            if ($mediaService->has($technology['path'])) {
                $technologyStruct['image'] = $this->makeImgPart(
                    $mediaService->getUrl($technology['path'])
                );
            }

            $converted[] = $technologyStruct;
        }

        return $converted;
    }

    /**
     * Returns sArticle['image'] like structure
     *
     * @param $imgSrc
     * @return array
     */
    private function makeImgPart($imgSrc)
    {
        return [
            'thumbnails' => [
                [
                    'sourceSet' => $imgSrc,
                ]
            ]
        ];
    }

    /**
     * Creates QueryBuilder for querying technologies and their media
     *
     * @param $perSite
     * @param $firstResult
     * @return \Doctrine\ORM\QueryBuilder
     * @throws Exception
     */
    private function getBaseTechnologyQueryBuilder()
    {
        return $this->getModelManager()->createQueryBuilder()
            ->select('t', 'm.path', 'm.description', 'm.extension', 'm.width', 'm.height')
            ->from(\VirtuaTechnology\Models\VirtuaTechnology::class, 't')
            ->leftJoin(
                \Shopware\Models\Media\Media::class,
                'm',
                \Doctrine\ORM\Query\Expr\Join::LEFT_JOIN,
                't.logo = m.id'
            );
    }
}
