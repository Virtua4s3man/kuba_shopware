<?php

class Shopware_Controllers_Backend_MailTemplate extends Shopware_Controllers_Backend_ExtJs
{
    public function yourAction()
    {
        $builder = $this->container->get('dbal_connection')->createQueryBuilder();

        $data = $builder->select('id, name')
            ->from('s_core_config_mails')
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);

//        $data = [
//            ['id' => 1, 'name' => 'foo'],
//            ['id' => 2, 'name' => 'bar'],
//        ];

        $this->view->assign([
            'data' => $data,
            'total' => count($data),
        ]);
    }
}
