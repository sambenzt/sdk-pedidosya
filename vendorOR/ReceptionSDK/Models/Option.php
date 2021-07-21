<?php

namespace ReceptionSDK\Models;

class Option extends Entity
{

    /**
     * The option optionGroup
     * @var OptionGroup
     */
    private $optionGroup;

    /**
     * The option price
     * @var int
     */
    private $price;

    /**
     * The option quantity
     * @var int
     */
    private $quantity;

    /**
     * The option modifies price
     * @var bool
     */
    private $modifiesPrice;

    /**
     * The option requires age check
     * @var bool
     */
    private $requiresAgeCheck;


    /**
     * Default Product constructor
     */
    public function __construct() {
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
     * @return OptionGroup
     */
    public function getOptionGroup()
    {
        return $this->optionGroup;
    }

    /**
     * @param OptionGroup $optionGroup
     */
    public function setOptionGroup($optionGroup)
    {
        $this->optionGroup = $optionGroup;
    }


    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param double $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


    /**
     * @return bool
     */
    public function getModifiesPrice()
    {
        return $this->modifiesPrice;
    }

    /**
     * @param bool $modifiesPrice
     */
    public function setModifiesPrice($modifiesPrice)
    {
        $this->modifiesPrice = $modifiesPrice;
    }

    /**
     * @return bool
     */
    public function getRequiresAgeCheck()
    {
        return $this->requiresAgeCheck;
    }

    /**
     * @param bool
     */
    public function setRequiesAgeCheck($requiresAgeCheck)
    {
        $this->requiresAgeCheck = $requiresAgeCheck;
    }

}
