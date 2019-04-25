<?php

class Shopware_Controllers_Backend_MailTemplate extends Shopware_Controllers_Backend_ExtJs
{
    /**
     * Fetchs mail templates from db
     */
    public function getMailTemplatesAction()
    {
        $builder = $this->container->get('dbal_connection')->createQueryBuilder();
        $data = $builder->select('id, name')
            ->from('s_core_config_mails')
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);

        $this->view->assign([
            'data' => $data,
            'total' => count($data),
        ]);
    }
}
