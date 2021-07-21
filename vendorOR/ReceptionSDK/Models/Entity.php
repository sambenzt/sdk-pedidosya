<?php

namespace ReceptionSDK\Models;

class Entity
{
    /**
     * The entity name. For example: 'Pizzas', 'Beberages'
     * @var string
     */
    private $name;
    /**
     * The entity index. For sorting purposes
     * @var int
     */
    private $index;
    /**
     * The entity identification number with external systems
     * @var string
     */
    private $integrationCode;
    /**
     * The entity identification name with external systems
     * @var string
     */
    private $integrationName;

    /**
     * The entity enabled field
     * @var bool
     */
    private $enabled;

    /**
     * Default Entity constructor
     */
    function __construct() { }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param int $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @return string
     */
    public function getIntegrationCode()
    {
        return $this->integrationCode;
    }

    /**
     * @param string $integrationCode
     */
    public function setIntegrationCode($integrationCode)
    {
        $this->integrationCode = $integrationCode;
    }

    /**
     * @return string
     */
    public function getIntegrationName()
    {
        return $this->integrationName;
    }

    /**
     * @param string $integrationName
     */
    public function setIntegrationName($integrationName)
    {
        $this->integrationName = $integrationName;
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}
