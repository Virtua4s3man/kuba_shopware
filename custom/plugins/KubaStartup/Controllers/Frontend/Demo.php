<?php

class Shopware_Controllers_Frontend_Demo extends Enlight_Controller_Action
{
    public function preDispatch()
    {
        $this->view->addTemplateDir(__DIR__ . '/../../Resources/views');
    }

    public function indexAction()
    {
        $action = $this->Request()->getActionName();
        $this->view->assign('next','next');
        $this->view->assign('action', $action);
    }

    public function nextAction()
    {
        $this->view->assign('index', 'index');
    }
}