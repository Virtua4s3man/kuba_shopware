<?php

namespace SwagAdvDevBundle7\Bundle\SearchBundle\Condition;

use Shopware\Bundle\SearchBundle\ConditionInterface;

class BundleCondition implements ConditionInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'swag_bundle';
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
