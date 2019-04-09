<?php

namespace VirtuaTechnology\SearchBundle\Facet;

use Shopware\Bundle\SearchBundle\FacetInterface;

class TechnologyFacet implements FacetInterface, \JsonSerializable
{
    public function getName()
    {
        return 'virtua_technology';
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
