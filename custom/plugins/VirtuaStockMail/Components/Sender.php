<?php

namespace VirtuaStockMail\Components;


use Shopware\Components\Model\ModelManager;
use Doctrine\Common\Util\Debug;

class Sender
{
    /** @var array $config */
    public $config;

    /** @var ModelManager $modelManager */
    private $modelManager;

    /** @var \Shopware_Components_TemplateMail $templateMail */
    private $templateMail;

    public function __construct(array $config, ModelManager $modelManager, \Shopware_Components_TemplateMail $templateMail)
    {
        $this->config = $config;
        $this->modelManager = $modelManager;
        $this->templateMail = $templateMail;
    }

    public function sendLowStockMail()
    {
        $mail = $this->templateMail->createMail(
            $this->config['emailTemplate'],
            ['lowStockItems' => $this->getLowStockItems()]
        );
        $mail->addTo('intern4@wearevirtua.com');
        $mail->send();
    }

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
            ->setParameter(':lowStockQty', $this->config['lowStockQty'], \PDO::PARAM_INT)
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

}