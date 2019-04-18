<?php

namespace VirtuaStockMail;

use Doctrine\Common\Util\Debug;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContext;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Models\Mail\Mail;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Shopware-Plugin VirtuaStockMail.
 */
class VirtuaStockMail extends Plugin
{
    private $templateName = 'VirtuaLowStockEmailTemplate';

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'registerView',
        ];
    }

    public function registerView(\Enlight_Controller_ActionEventArgs $args)
    {
        $args->getSubject()->View()->addTemplateDir($this->getPath() . '/Resources/views');
    }

    public function install(InstallContext $context)
    {
        Shopware()->Container()->get('templatemail');
        $modelManager = $this->container->get('models');

        if (!$this->getLowStockMailTemplate($modelManager)) {
            $mailTemplate = $this->createMailTemplate();
            $modelManager->persist($mailTemplate);
            $modelManager->flush();
        }
    }

    public function uninstall(UninstallContext $context)
    {
        if ($context->keepUserData()) {
            return;
        }
        $modelManager = $this->container->get('models');

        $mailTemplate = $this->getLowStockMailTemplate($modelManager);
        if ($mailTemplate) {
            $modelManager->remove($mailTemplate);
            $modelManager->flush();
        }
    }

    /**
     * @return Mail
     */
    private function createMailTemplate()
    {
        $mail = new Mail();
        $mail->setName($this->templateName);
        $mail->setSubject('Low quantity of products in your stock!');
        $mail->setIsHtml(1);
        $mail->setContent('{include file="string:{config name=emailheaderplain}"}
Your low products quantities
{foreach item=instock key=name from=$lowStockItems}
    {$name}                 {$instock}
    
{/foreach}
{include file="string:{config name=emailfooterplain}"}
');
        $mail->setContentHtml('<div style="font-family:arial; font-size:12px;">
    {include file="string:{config name=emailheaderhtml}"}
     <h1>Your low products quantities</h1>
     <table>
    {foreach item=instock key=name from=$lowStockItems}
        <tr>
            <td>{$name}</td>
            <td>{$instock}</td>
        </tr>
        </br>
    {/foreach}
    </table>
             
    {include file="string:{config name=emailfooterhtml}"}
</div>');
        $mail->setFromMail('{config name=mail}');
        $mail->setFromName('{config name=shopName}');

        return $mail;
    }

    /**
     * @return Mail|null
     */
    private function getLowStockMailTemplate(ModelManager $modelManager)
    {
        $mailTemplate = $modelManager->getRepository(Mail::class)->findOneBy(
            ['name' => $this->templateName]
        );

        return $mailTemplate ? $mailTemplate : null;
    }
}
