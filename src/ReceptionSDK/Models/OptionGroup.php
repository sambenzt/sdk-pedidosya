<?php

namespace ReceptionSDK\Models;

class OptionGroup extends Entity
{
    /**
     * The OptionGroup product
     * @var Product
     */
    private $product;

    /**
     * The optionGroup maximum quantity
     * @var int
     */
    private $maximumQuantity;

    /**
     * The optionGroup minimum quantity
     * @var int
     */
    private $minimumQuantity;




    /**
     * Default OptionGroup constructor
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
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return int maximumQuantity
     */
    public function getMaximumQuantity()
    {
        return $this->maximumQuantity;
    }

    /**
     * @param int $maximumQuantity
     */
    public function setMaximumQuantity($maximumQuantity)
    {
        $this->maximumQuantity = $maximumQuantity;
    }

    /**
     * @return int minimumQuantity
     */
    public function getMinimumQuantity()
    {
        return $this->minimumQuantity;
    }

    /**
     * @param int $minimumQuantity
     */
    public function setMinimumQuantity($minimumQuantity)
    {
        $this->minimumQuantity = $minimumQuantity;
    }











}
