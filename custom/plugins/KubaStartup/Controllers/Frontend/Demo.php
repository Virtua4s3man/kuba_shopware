<?php

class Shopware_Controllers_Frontend_Demo extends Enlight_Controller_Action
{
    public function indexAction()
    {
        $action = $this->Request()->getActionName();
        $this->view->assign('next','next');
        $this->view->assign('action', $action);
    }

    public function nextAction()
    {
        $client = new \KubaStartup\Components\ApiClient(
            'localhost/api',
            'demo',
            'ik67sVLGQiP0KZlsRBe0gqtlN6zgyP8S1xw9Go8J'
        );
        $data = $client->get('bundles/17');
        //todo pytanie dlaczego resource z bundles dostępne sa tylko get-em a nie postem
        dump($data);

        $this->view->assign('index', 'index');
    }
}