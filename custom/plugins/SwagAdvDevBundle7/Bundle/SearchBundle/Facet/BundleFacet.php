<?php

namespace SwagAdvDevBundle7\Bundle\SearchBundle\Facet;

use Shopware\Bundle\SearchBundle\FacetInterface;

class BundleFacet implements FacetInterface
{
    /**
     * {@inheritdoc}
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
