<?php

namespace VirtuaTechnology\SearchBundle\Condition;

use Shopware\Bundle\SearchBundle\ConditionInterface;

class TechnologyCondition implements ConditionInterface, \JsonSerializable
{
    /**
     * @var $technologies string, technology ids surounded and splited by |
     * @example |1|2|3|
     */
    private $technologies;

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