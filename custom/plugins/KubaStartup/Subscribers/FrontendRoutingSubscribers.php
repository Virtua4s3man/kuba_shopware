<?php

namespace KubaStartup\Subscribers;

use Enlight\Event\SubscriberInterface;

class FrontendRoutingSubscribers implements SubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend_Demo' => 'onPreDispatchTemplateRegistration',
        ];
    }

    public function onPreDispatchTemplateRegistration(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Frontend_Demo $subject */
        $controller = $args->getSubject();

        $controller->View()->addTemplateDir(__DIR__ . '/../Resources/views');
    }
}