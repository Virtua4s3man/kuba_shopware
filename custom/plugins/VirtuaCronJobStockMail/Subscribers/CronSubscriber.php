<?php

namespace VirtuaCronJobStockMail\Subscribers;

use Enlight\Event\SubscriberInterface;

class CronSubscriber implements SubscriberInterface
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_StockMail' => 'onStockMail'
        ];
    }

    /**
     * Send low stock mail to shop owner
     * @param \Shopware_Components_Cron_CronJob $job
     */
    public function onStockMail(\Shopware_Components_Cron_CronJob $job)
    {
        $sender = Shopware()->Container()->get('virtua_stock_mail.components.sender');
        $sender->sendLowStockMail();
    }
}
