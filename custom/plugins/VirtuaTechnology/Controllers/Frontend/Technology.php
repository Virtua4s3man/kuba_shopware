<?php

class Shopware_Controllers_Frontend_Technology extends Enlight_Controller_Action
{
    public function indexAction()
    {
        $modelManager = $this->getModelManager();
        $query = $modelManager->createQueryBuilder()
            ->select('technology')
            ->from(\VirtuaTechnology\Models\VirtuaTechnology::class, 'technology')
            ->getQuery();
        $query->setHydrationMode(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $paginator = $modelManager->createPaginator($query);

        $data = $paginator->getIterator()->getArrayCopy();
        $data['articleName'] = $data['name'];

        $this->View()->assign(
            'technologies',
            $data
        );

        $this->View()->assign('pages', $paginator->count());
    }

    public function detailAction(){

    }
}