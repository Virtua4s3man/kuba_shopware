<?php

namespace VirtuaFeaturedProducts;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Shopware-Plugin VirtuaFeaturedProducts.
 */
class VirtuaFeaturedProducts extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
          'Enlight_Controller_Action_PostDispatch_Backend_Base' => 'addBackendTemplate',
        ];
    }

    public function addBackendTemplate(\Enlight_Controller_ActionEventArgs $args)
    {
        /** @var \Enlight_View_Default $view */
        $view = $args->getSubject()->View();
        $view->addTemplateDir($this->getPath() . 'Resources/views/');
//todo zrobić rzeby działało z tłumaczeniami
//        $view->extendsTemplate('backend/base/attribute/form/featured.js');
    }

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('virtua_featured_products.plugin_dir', $this->getPath());
        parent::build($container);
    }

    public function install(InstallContext $context)
    {
        $crudService = $this->container->get('shopware_attribute.crud_service');
        $crudService->update(
            's_articles_attributes',
            'is_featured',
            'boolean',
            [
                'displayInBackend' => true,
                'label' => 'is Featured',
            ],
            null,
            false,
            false
        );
    }

    public function uninstall(UninstallContext $context)
    {
        if ($context->keepUserData()) {
            return;
        }

        $crudService = $this->container->get('shopware_attribute.crud_service');
        $crudService->delete(
            's_articles_attributes',
            'is_featured'
        );
    }

}
