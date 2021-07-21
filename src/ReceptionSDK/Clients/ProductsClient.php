<?php

namespace ReceptionSDK\Clients;

use ErrorException;
use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Exceptions\NullArgumentException;
use ReceptionSDK\Helpers\Ensure;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Request;

/**
 * Class ProductsClient
 * A client for Products API.
 * @package ReceptionSDK\Clients
 */
class ProductsClient extends MenuItemClient
{

    /**
     * ProductsClient constructor.
     * Instantiate a new Products API client.
     * @param ApiConnection $connection
     */
    public function __construct($connection)
    {
        Ensure::argumentNotNull($connection, 'connection');
        parent::__construct($connection, 'products');
    }

    public function getByName($product, $restaurantId = null) {
        throw new ApiException('This operation is not allowed');
    }

    public function getAllSchedules($product, $restaurantId = null) {
        throw new ApiException('This operation is not allowed');
    }

    public function createSchedule($product, $restaurantId = null) {
        throw new ApiException('This operation is not allowed');
    }

    public function deleteSchedule($product, $restaurantId = null) {
        throw new ApiException('This operation is not allowed');
    }

    public function getItemRoute($menuItem)
    {
        return 'product';
    }

    public function getItemsRoute($product)
    {
        return 'product/sectionIntegrationCode/' . $product->getSection()->getIntegrationCode();
    }

    public function getItemPayload($product, $restaurantId = null)
    {
        $body = [];

        if (!is_null($product)) {
            $this->product = $product;
            if (!is_null($product->getSection())) {
                $body['section'] = [];
                if (!is_null($product->getSection()->getIntegrationCode())) {
                    $body['section']['integrationCode'] = $this->product->getSection()->getIntegrationCode();
                }
                if (!is_null($product->getSection()->getName())) {
                    $body['section']['name'] = $this->product->getSection()->getName();
                }
            }
            if (!is_null($product->getName())) {
                $body['name'] = $this->product->getName();
            }
            if (!is_null($product->getIntegrationCode())) {
                $body['integrationCode'] = $this->product->getIntegrationCode();
            }
            if (!is_null($product->getGtin())) {
                $body['gtin'] = $this->product->getGtin();
            }
            if (!is_null($product->getIntegrationName())) {
                $body['integrationName'] = $this->product->getIntegrationName();
            }
            if (!is_null($product->getImage())) {
                $body['image'] = $this->product->getImage();
            }
            if (!is_null($product->getPrice())) {
                $body['price'] = $this->product->getPrice();
            }
            if (!is_null($product->getDescription())) {
                $body['description'] = $this->product->getDescription();
            }
            if (!is_null($product->getIndex())) {
                $body['index'] = $this->product->getIndex();
            }
            if (!is_null($product->getEnabled())) {
                $body['enabled'] = $this->product->getEnabled();
            }
            if (!is_null($product->isRequiresAgeCheck())) {
                $body['requiresAgeCheck'] = $this->product->isRequiresAgeCheck();
            }
            if (!is_null($product->getMeasurementUnit())) {
                $body['measurementUnit'] = $this->product->getMeasurementUnit();
            }
            if (!is_null($product->getContentQuantity())) {
                $body['contentQuantity'] = $this->product->getContentQuantity();
            }
            if (!is_null($product->getPrescriptionBehaviour())) {
                $body['prescriptionBehaviour'] = $this->product->getPrescriptionBehaviour();
            }
        }
        return $body;
    }
}
