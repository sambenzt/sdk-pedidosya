<?php

namespace ReceptionSDK\Models;

class Product extends Entity
{

    /**
     * The product description. For example: '200 gr. ground beef burger with french fries.'
     * @var string
     */
    private $description;

    /**
     * The product section
     * @var Section
     */
    private $section;


    /**
     * The product's image id
     * @var string
     */
    private $image;

    /**
     * The product price
     * @var double
     */
    private $price;

    /**
     * The product's gtin
     * @var string
     */
    private $gtin;


    /**
     * The product's requires Age check
     * @var bool
     */
    private $requiresAgeCheck;

    /**
     * The product's measurement Unit
     * @var string
     */
    private $measurementUnit;

    /**
     * The product's content Quantity
     * @var double
     */
    private $contentQuantity;

    /**
     * The product's prescription Behaviour
     * @var string
     */
    private $prescriptionBehaviour;


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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param Section $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     * @return string
     */
    public function getGtin()
    {
        return $this->gtin;
    }

    /**
     * @param string $gtin
     */
    public function setGtin($gtin)
    {
        $this->gtin = $gtin;
    }

    /**
     * @return bool
     */
    public function isRequiresAgeCheck()
    {
        return $this->requiresAgeCheck;
    }

    /**
     * @param bool requiresAgeCheck
     */
    public function setRequiresAgeCheck($requiresAgeCheck)
    {
        $this->requiresAgeCheck = $requiresAgeCheck;
    }

    /**
     * @return string
     */
    public function getMeasurementUnit()
    {
        return $this->measurementUnit;
    }

    /**
     * @param string measurementUnit
     */
    public function setMeasurementUnit($measurementUnit)
    {
        $this->measurementUnit = $measurementUnit;
    }

    /**
     * @return double
     */
    public function getContentQuantity()
    {
        return $this->contentQuantity;
    }

    /**
     * @param double contentQuantity
     */
    public function setContentQuantity($contentQuantity)
    {
        $this->contentQuantity = $contentQuantity;
    }

     /**
     * @return string
     */
    public function getPrescriptionBehaviour()
    {
        return $this->prescriptionBehaviour;
    }

    /**
     * @param string prescriptionBehaviour
     */
    public function setPrescriptionBehaviour($prescriptionBehaviour)
    {
        $this->prescriptionBehaviour = $prescriptionBehaviour;
    }

}
