<?php

namespace VirtuaFeaturedProducts\Tests;

use VirtuaFeaturedProducts\VirtuaFeaturedProducts as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'VirtuaFeaturedProducts' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['VirtuaFeaturedProducts'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
