<?php

namespace VirtuaStockMail;

use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Models\Mail\Mail;

/**
 * Shopware-Plugin VirtuaStockMail.
 */
class VirtuaStockMail extends Plugin
{
    /** @var string  */
    private $templateName = 'VirtuaLowStockEmailTemplate';

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'registerView',
        ];
    }

    /**
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function registerView(\Enlight_Controller_ActionEventArgs $args)
    {
        $args->getSubject()->View()->addTemplateDir($this->getPath() . '/Resources/views');
    }

    /**
     * @param InstallContext $context
     * @throws \Doctrine\ORM\OptimisticLockException
     */
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

    /**
     * @param UninstallContext $context
     * @throws \Doctrine\ORM\OptimisticLockException
     */
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
        $mail->setContent(
            $this->getTemplateContent('VirtuaLowStock')
        );
        $mail->setContentHtml(
            $this->getTemplateContent('VirtuaLowStock.html')
        );
        $mail->setFromMail('{config name=mail}');
        $mail->setFromName('{config name=shopName}');

        return $mail;
    }

    /**
     * @param ModelManager $modelManager
     * @return object|Mail|null
     */
    private function getLowStockMailTemplate(ModelManager $modelManager)
    {
        $mailTemplate = $modelManager->getRepository(Mail::class)->findOneBy(
            ['name' => $this->templateName]
        );

        return $mailTemplate ? $mailTemplate : null;
    }

    /**
     * @param $templateName
     * @return string
     */
    private function getTemplateContent($templateName)
    {
        $content = file_get_contents($this->getPath() . '/EmailTemplates/' . $templateName);
        return $content ? $content : '';
    }
}
