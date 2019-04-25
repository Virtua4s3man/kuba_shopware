<?php

namespace VirtuaShipping\Subscriber;

use Enlight\Event\SubscriberInterface;
use VirtuaShipping\Components\ShippingService;

class ProductDetailSubscriber implements SubscriberInterface
{
    /** @var ShippingService */
    private $shippingService;

    /**
     * ProductDetailSubscriber constructor.
     * @param ShippingService $shippingService
     */
    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'updateView'
        );
    }

    /**
     * Provide extra shipping data
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function updateView(\Enlight_Controller_ActionEventArgs $args)
    {
        /** @var \Enlight_View_Default $view */
        $view = $args->getSubject()->View();

        $article = $view->getAssign('sArticle');
        $view->clearAssign('sArticle');

        $article['delivery_time'] = $this->shippingService->
            resolveEstimatedDeliveryTime($article['shipping_in']);

        $view->assign('sArticle', $article);
    }
}
