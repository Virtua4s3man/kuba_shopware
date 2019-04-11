<?php

namespace VirtuaShipping\Subscriber;

use Doctrine\DBAL\Query\QueryBuilder;
use Enlight\Event\SubscriberInterface;
use VirtuaShipping\Components\ShippingService;

class ProductDetailSubscriber implements SubscriberInterface
{
    /** @var ShippingService */
    private $shippingService;

    /**
     * ProductDetailSubscriber constructor.
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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'maybeReplaceAddToCartButton'
        );
    }

    /**
     * Provide extra shipping data
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function maybeReplaceAddToCartButton(\Enlight_Controller_ActionEventArgs $args)
    {
        $now = new \DateTime('now');
        /** @var \Enlight_View_Default $view */
        $view = $args->getSubject()->View();
    }
}
