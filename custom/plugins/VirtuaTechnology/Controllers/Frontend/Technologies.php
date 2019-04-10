<?php
/**
 * User: virtua
 * Date: 2019-04-04
 * Time: 15:55
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

/**
 * Class Technologies controller
 */
class Shopware_Controllers_Frontend_Technologies extends Enlight_Controller_Action
{
    /**
     * Display paginated technologies with images
     *
     * @throws Exception
     */
    public function indexAction()
    {
        $technologyService = $this->container->get('virtua_technology.components.technology_service');

        $sPage = intval($this->Request()->getParam('p', 1));
        if ($sPage < 1) {
            $sPage = 1;
        }

        $paginator = $technologyService->getTechnologiesPaginator($sPage);
        $technologies = $technologyService->convertTechnologiesToArticleStruct(
            $paginator->getIterator()->getArrayCopy()
        );

        $this->View()->assign([
            'shortParameters' => $this->get('query_alias_mapper')->getQueryAliases(),
            'showListing' => true,
            'sPage' => $sPage,
            'sArticles' => $technologies,
            'theme' => ['infiniteScrolling' => false],
            't_pages' => $technologyService->countPages($paginator),
        ]);
    }

    /**
     * Assign technology data to View
     *
     * @throws Exception
     */
    public function detailAction()
    {
        $id = intval($this->Request()->getParam('technologyId'));
        $service = $this->container->get('virtua_technology.components.technology_service');
        $technology = $service->findTechnologiesByIds([$id]);

        if (!$technology) {
            return $this->forward('pageNotFoundError');
        }

        $this->View()->assign(
            'sArticle',
            array_shift(
                $service->convertTechnologiesToArticleStruct($technology)
            )
        );
    }
}
