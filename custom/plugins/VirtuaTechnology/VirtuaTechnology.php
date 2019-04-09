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

namespace VirtuaTechnology;

use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Bundle\AttributeBundle\Service\CrudService;
use Shopware\Bundle\AttributeBundle\Service\TypeMapping;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

/**
 * Shopware-Plugin VirtuaTechnology.
 */
class VirtuaTechnology extends Plugin
{

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch'
        ];
    }

    public function onPreDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        $args->getSubject()->View()->addTemplateDir($this->getPath() . '/Resources/views/');
    }

    /**
     * @param InstallContext $context
     *
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function install(InstallContext $context)
    {
        if ($this->schemaExists('virtua_technology')) {
            return;
        }

        /** @var CrudService $attributeCrud */
        $attributeCrud = $this->container->get('shopware_attribute.crud_service');

        $attributeCrud->update(
            's_articles_attributes',
            'technology',
            'multi_selection',
            [
                'label' => 'technology',
                'supportText' => 'product technology',
                'displayInBackend' => true,
                'translatable' => true,
                'entity' => 'VirtuaTechnology\Models\VirtuaTechnology',
            ]
        );

        $tool = new SchemaTool($this->container->get('models'));
        $classes = $this->getModelMetaData();
        $tool->createSchema($classes);
    }

    public function uninstall(UninstallContext $context)
    {
        if ($context->keepUserData()) {
            return;
        }

        /** @var CrudService $crudService */
        $attributeCrud = $this->container->get('shopware_attribute.crud_service');
        $attributeCrud->delete(
            's_articles_attributes',
            'technology'
        );

        $tool = new SchemaTool($this->container->get('models'));
        $classes = $this->getModelMetaData();
        $tool->dropSchema($classes);
    }

    /**
     * Get entity metadata
     *
     * @return array
     */
    private function getModelMetaData()
    {
        return [$this->container->get('models')->getClassMetadata(Models\VirtuaTechnology::class)];
    }

    /**
     * Checks if schema exists
     *
     * @param $name
     * @return bool
     */
    private function schemaExists($name)
    {
        return $this->container->get('dbal_connection')->getSchemaManager()
                ->tablesExist([$name]) === true;
    }
}
