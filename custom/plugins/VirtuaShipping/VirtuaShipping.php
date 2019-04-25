<?php
/**
 * User: virtua
 * Date: 2019-04-11
 * Time: 10:47
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @license GNU GPLv3
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

namespace VirtuaShipping;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Shopware\Bundle\AttributeBundle\Service\CrudService;

/**
 * Shopware-Plugin VirtuaShipping.
 */
class VirtuaShipping extends Plugin
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch'
        ];
    }

    /**
     * Add template dir
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function onPreDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        $args->getSubject()->View()->addTemplateDir($this->getPath() . '/Resources/views/');
    }

    /**
     * @param InstallContext $context
     * @throws \Exception
     */
    public function install(InstallContext $context)
    {
        /** @var CrudService $attributeCrud */
        $attributeCrud = $this->container->get('shopware_attribute.crud_service');

        $attributeCrud->update(
            's_articles_attributes',
            'shipping_in',
            'integer',
            [
                'label' => 'shipping_in',
                'supportText' => 'number of days required to deliver the package',
                'displayInBackend' => true,
                'translatable' => true,
            ],
            null,
            false,
            1
        );
    }

    /**
     * @param UninstallContext $context
     * @throws \Exception
     */
    public function uninstall(UninstallContext $context)
    {
        if ($context->keepUserData()) {
            return;
        }

        /** @var CrudService $crudService */
        $attributeCrud = $this->container->get('shopware_attribute.crud_service');
        $attributeCrud->delete(
            's_articles_attributes',
            'shipping_in'
        );
    }

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('virtua_shipping.plugin_dir', $this->getPath());
        parent::build($container);
    }
}
