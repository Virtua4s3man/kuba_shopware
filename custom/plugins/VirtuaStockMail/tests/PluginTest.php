<?php

namespace VirtuaStockMail\Tests;

use VirtuaStockMail\Components\Sender;
use VirtuaStockMail\VirtuaStockMail as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'VirtuaStockMail' => [
        ]
    ];

    protected $config1 = [
            'lowStockAlert' => false,
            'lowStockQty' => 3,
            'emailTemplate' => 'VirtuaLowStockEmailTemplate',
        ];

    public function testEmailCreation()
    {
        $templatemail = Shopware()->Container()->get('templatemail');
        $modelManager = Shopware()->Container()->get('models');

        $sender = new Sender($this->config1, $modelManager, $templatemail);
        try {
            $sender->sendLowStockMail();
        }catch (\Exception $e) {
            $this->assertFalse(true);
        }
    }
}
