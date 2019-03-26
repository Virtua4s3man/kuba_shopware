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

namespace VirtuaFeaturedProducts\Subscribers;

use Enlight\Event\SubscriberInterface;

/**
 * Class responsible for adding view templates and variables
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @license GNU GPLv3
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */
class FrontendRoutingSubscriber implements SubscriberInterface
{
    /**
     * Returns array of subscribed_event => action_on_event
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
          'Enlight_Controller_Action_PreDispatch' => 'addTemplateDir',
        ];
    }

    /**
     * Register plugin views directory
     *
     * @param \Enlight_Controller_ActionEventArgs $args event payload
     */
    public function addTemplateDir(\Enlight_Controller_ActionEventArgs $args)
    {
        $args->getSubject()->View()->addTemplateDir(__DIR__ . '/../Resources/views');
    }
}
