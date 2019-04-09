<?php
/**
 * User: virtua
 * Date: 2019-04-04
 * Time: 15:55
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

namespace VirtuaTechnology\Subscribers;

use Doctrine\ORM\QueryBuilder;
use Enlight\Event\SubscriberInterface;

/**
 * Class TechnologyProductDetailSubscriber
 * @package VirtuaTechnology\Subscribers
 */
class TechnologyProductDetailSubscriber implements SubscriberInterface
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'assignTechnologiesToView',
        ];
    }

    public function assignTechnologiesToView(\Enlight_Controller_ActionEventArgs $args)
    {
        $view = $args->getSubject()->View();
        $ids = $this->getTechnologyIds($view);

        if ($ids) {
            $technologyService = Shopware()->Container()->get('virtua_technology.components.technology_service');
            $view->assign('technologies', $technologyService->findTechnologiesByIds($ids));
        }
        dump($technologyService->findTechnologiesByIds($ids));
    }

    private function getTechnologyIds(\Enlight_View_Default $view)
    {
        $article = $view->getAssign('sArticle');

        return isset($article['technology']) ?
            explode(
                '|',
                trim($article['technology'], '|')
            )
            : null;
    }

}
