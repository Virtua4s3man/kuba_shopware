<?php

namespace VirtuaHidePrices;

use Shopware\Components\Plugin;

class VirtuaHidePrices extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'registerViewsDir',
        ];
    }

    /**
     * Register plugin views directory
     *
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function registerViewsDir(\Enlight_Controller_ActionEventArgs $args)
    {
        $args->getSubject()->View()->addTemplateDir($this->getPath() . '/Resources/views/');
    }
}
