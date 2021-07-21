<?php

namespace ReceptionSDK\Models;

class Section extends Entity
{
    /**
     * The partner identification with external systems
     * @var int
     */
    private $partnerId;

    /**
     * Default Section constructor
     */
    function __construct() {
        return parent::__construct();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return parent::getName();
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        return parent::setName($name);
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return parent::getIndex();
    }

    /**
     * @param int $index
     */
    public function setIndex($index)
    {
        return parent::setIndex($index);
    }

    /**
     * @return string
     */
    public function getIntegrationCode()
    {
        return parent::getIntegrationCode();
    }

    /**
     * @param string $integrationCode
     */
    public function setIntegrationCode($integrationCode)
    {
        return parent::setIntegrationCode($integrationCode);
    }

    /**
     * @return string
     */
    public function getIntegrationName()
    {
        return parent::getIntegrationName();
    }

    /**
     * @param string $integrationName
     */
    public function setIntegrationName($integrationName)
    {
        return parent::setIntegrationName($integrationName);
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return parent::getEnabled();
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        return parent::setEnabled($enabled);
    }

    /**
     * @return string
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * @param string $partnerId
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;
    }

}
