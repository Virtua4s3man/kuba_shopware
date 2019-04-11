<?php
/**
 * User: virtua
 * Date: 2019-04-04
 * Time: 15:55
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

namespace VirtuaTechnology\Components;

use Shopware\Bundle\MediaBundle\MediaService;
use Shopware\Components\Model\ModelManager;

/**
 * Class TechnologyService
 */
class TechnologyService
{
    /** @var ModelManager  */
    private $modelManager;

    /** @var array $configuration */
    private $configuration;

    /** @var MediaService $mediaService*/
    private $mediaService;

    /**
     * TechnologyService constructor.
     * @param ModelManager $modelManager
     * @param array $configuration
     * @param MediaService $mediaService
     */
    public function __construct(ModelManager $modelManager, array $configuration, MediaService $mediaService)
    {
        $this->modelManager = $modelManager;
        $this->configuration = $configuration;
        $this->mediaService = $mediaService;
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countPages()
    {
        $allPages = $this->modelManager->createQuery(
            'SELECT COUNT(t.id) FROM VirtuaTechnology\Models\VirtuaTechnology t'
        )->getSingleScalarResult();

        return (int) round($allPages / $this->configuration['perSite']);
    }

    /**
     * Find one or many technology by id
     * @param $ids array
     *
     * @return array
     */
    public function findTechnologiesByIds($ids)
    {
        return $this->getBaseTechnologyQueryBuilder()
            ->where("t.id IN(:id)")
            ->setParameter('id', $ids)
            ->getQuery()
            ->setHydrationMode(\Doctrine\ORM\Query::HYDRATE_SCALAR)
            ->execute();
    }

    /**
     * Create paginator for fetched technologies
     *
     * @param $sPage int current page
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     * @throws Exception
     */
    public function getTechnologiesPaginator($sPage)
    {
        $firstResult = ($sPage - 1) * $this->configuration['perSite'];
        $query = $this->getBaseTechnologyQueryBuilder()
            ->setFirstResult($firstResult)
            ->setMaxResults($this->configuration['perSite'])
            ->getQuery();
        $query->setHydrationMode(\Doctrine\ORM\Query::HYDRATE_SCALAR);

        return $this->modelManager->createPaginator($query);
    }

    /**
     * Convert fetched technologies array to sArticle like structure used on frontend
     *
     * @param array $technologies
     * @return array
     * @throws Exception
     */
    public function convertTechnologiesToArticleStruct(array $technologies)
    {
        $converted = [];
        foreach ($technologies as $technology) {
            $technologyStruct = [];
            $technologyStruct['articleName'] = $technology['t_name'];
            $technologyStruct['linkDetails'] = 'technologies/' . $technology['t_url'];
            $technologyStruct['description_long'] = $technology['t_description'];

            if ($this->mediaService->has($technology['path'])) {
                $technologyStruct['image'] = $this->makeImgPart(
                    $this->mediaService->getUrl($technology['path'])
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
     * @return \Doctrine\ORM\QueryBuilder
     * @throws Exception
     */
    private function getBaseTechnologyQueryBuilder()
    {
        return $this->modelManager->createQueryBuilder()
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
