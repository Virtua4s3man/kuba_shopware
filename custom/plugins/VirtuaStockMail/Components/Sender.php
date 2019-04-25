<?php

namespace VirtuaStockMail\Components;

use Shopware\Components\Model\ModelManager;

class Sender
{
    /** @var array $pluginConfig */
    private $pluginConfig;

    /** @var ModelManager $modelManager */
    private $modelManager;

    /** @var \Shopware_Components_TemplateMail $templateMail */
    private $templateMail;

    /** @var \Shopware_Components_Config  */
    private $shopwareConfig;

    /**
     * Sender constructor.
     * @param array $pluginConfig
     * @param ModelManager $modelManager
     * @param \Shopware_Components_TemplateMail $templateMail
     * @param \Shopware_Components_Config $shopwareConfig
     */
    public function __construct(
        array $pluginConfig,
        ModelManager $modelManager,
        \Shopware_Components_TemplateMail $templateMail,
        \Shopware_Components_Config $shopwareConfig
    ) {
        $this->pluginConfig = $pluginConfig;
        $this->modelManager = $modelManager;
        $this->templateMail = $templateMail;
        $this->shopwareConfig = $shopwareConfig;
    }

    /**
     * @throws \Enlight_Exception
     */
    public function sendLowStockMail()
    {
        if ($this->pluginConfig['lowStockAlert'] === false) {
            return;
        }

        $mail = $this->templateMail->createMail(
            $this->pluginConfig['emailTemplate'],
            ['lowStockItems' => $this->getLowStockItems()]
        );
        $mail->addTo(
            $this->shopwareConfig->get('mail')
        );

        $mail->send();
    }

    /**
     * @return array
     */
    private function getLowStockItems()
    {
        $builder = $this->modelManager->getDBALQueryBuilder();
        return $builder->select('product.name, detail.instock')
            ->from('s_articles', 'product')
            ->leftJoin(
                'product',
                's_articles_details',
                'detail',
                'product.id = detail.articleID'
            )->where('detail.instock <= :lowStockQty')
            ->andWhere('detail.kind = 1')
            ->setParameter(':lowStockQty', $this->pluginConfig['lowStockQty'], \PDO::PARAM_INT)
            ->execute()
            ->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
}
