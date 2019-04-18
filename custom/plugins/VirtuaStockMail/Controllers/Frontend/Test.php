<?php

class Shopware_Controllers_Frontend_Test extends Enlight_Controller_Action
{
    public function indexAction()
    {

        $sender = Shopware()->Container()->get('virtua_stock_mail.components.sender');
//        dump($config);
        try {
            $sender->sendLowStockMail();
        }catch (\Exception $e) {
            dump($e);
        }
    }
}