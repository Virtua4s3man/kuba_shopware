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

namespace VirtuaHidePrices\Subscribers;

use Enlight\Event\SubscriberInterface;

/**
 * Class responsible for adding view templates and variables
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @license GNU GPLv3
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */
class FrontendGlobalsSubscriber implements SubscriberInterface
{
    /**
     * @var bool
     */
    private $displayPrice;

    /**
     * FrontendGlobalsSubscriber constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->displayPrice = $config['hide_prices_for_anonymous'] ?
            Shopware()->Modules()->Admin()->sCheckUser() : true;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'provideDisplayPriceFlag',
            'Enlight_Controller_Action_PostDispatchSecure_Widgets' => 'provideDisplayPriceFlag',
        ];
    }

    /**
     * Pass displayPrice variable to views
     *
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function provideDisplayPriceFlag(\Enlight_Controller_ActionEventArgs $args)
    {
            $args->getSubject()->View()->assign(
                'displayPrice',
                $this->displayPrice
            );
    }
}
