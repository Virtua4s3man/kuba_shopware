<?php

namespace SwagExtendBackend;

use Shopware\Components\Plugin;

class SwagExtendBackend extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Customer' => 'extendCustomerModule',
        ];
    }

    /**
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function extendCustomerModule(\Enlight_Controller_ActionEventArgs $args)
    {
        /** @var \Enlight_Controller_Request_Request $request */
        $request = $args->getSubject()->Request();

        /** @var \Enlight_View_Default $view */
        $view = $args->getSubject()->View();

        // register templates
        $view->addTemplateDir($this->getPath() . '/Resources/views');

        if ($request->getActionName() === 'load') {
            $view->extendsTemplate('backend/customer/swag_extend_backend/view/detail/window.js');
        }

        if ($request->getActionName() === 'index') {
            $view->extendsTemplate('backend/customer/swag_extend_backend/app.js');
        }
    }
}
