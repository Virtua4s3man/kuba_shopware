<?php
/**
 * User: virtua
 * Date: 2019-03-26
 * Time: 14:38
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @license GNU GPLv3
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

namespace VirtuaFeaturedProducts;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

/**
 * Shopware-Plugin VirtuaFeaturedProducts.
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @license GNU GPLv3
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */
class VirtuaFeaturedProducts extends Plugin
{
    /**
     * Runs on plugin installation
     *
     * @param InstallContext $context install context
     *
     * @throws \Exception
     */
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

    /**
     * Runs on plugin deinstallation
     *
     * @param UninstallContext $context uninstall context
     *
     * @throws \Exception
     */
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
