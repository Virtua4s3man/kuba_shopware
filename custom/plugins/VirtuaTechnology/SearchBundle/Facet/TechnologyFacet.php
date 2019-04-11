<?php
/**
 * User: virtua
 * Date: 2019-04-04
 * Time: 15:55
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

namespace VirtuaTechnology\SearchBundle\Facet;

use Shopware\Bundle\SearchBundle\FacetInterface;

/**
 * Class TechnologyFacet
 */
class TechnologyFacet implements FacetInterface, \JsonSerializable
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'virtua_technology';
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
