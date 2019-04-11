<?php
/**
 * User: virtua
 * Date: 2019-04-04
 * Time: 15:55
 *
 * @author  Kuba Kułaga <intern4@wearevirtua.com>
 * @link    https://github.com/virtIntern4a/kuba_shopware
 */

namespace VirtuaTechnology\SearchBundle\Condition;

use Shopware\Bundle\SearchBundle\ConditionInterface;

/**
 * Class TechnologyCondition
 */
class TechnologyCondition implements ConditionInterface, \JsonSerializable
{
    /**
     * @var $technologies string, ids splited by |
     * @example 1|2|3
     */
    private $technologies;

    /**
     * TechnologyCondition constructor.
     */
    public function __construct($technologies)
    {
        $this->technologies = $technologies;
    }


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'virtua_technology';
    }

    /**
     * @return mixed
     */
    public function getTechnologies()
    {
        return $this->technologies;
    }

    /**
     * @param string $technologies
     */
    public function setTechnologies($technologies)
    {
        $this->technologies = $technologies;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
