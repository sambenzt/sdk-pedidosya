<?php

namespace ReceptionSDK\Clients;

use ReceptionSDK\ApiClient;
use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Helpers\Ensure;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Request;
use ReceptionSDK\Models\OptionGroup;
use ReceptionSDK\Utils\PaginationOptions;

/**
 * Class OptionGroupClient
 * A client for OptionGroup API.
 * @package ReceptionSDK\Clients
 */
class OptionGroupClient extends MenuItemClient
{
    /**
     * @var ApiConnection
     */
    protected $connection;

    /**
     * CatalogueProductsClient constructor.
     * Instantiate a new CatalogueProducts API client.
     * @param ApiConnection $connection
     */
    public function __construct($connection)
    {
        Ensure::argumentNotNull($connection, 'connection');
        parent::__construct($connection, 'optionGroup');
    }

    public function getAllSchedules($scheduleItem, $restaurantId = null) {
        throw new ApiException('This operation is not allowed');
    }

    public function createSchedule($scheduleItem, $restaurantId = null) {
        throw new ApiException('This operation is not allowed');
    }

    public function deleteSchedule($scheduleItem, $restaurantId = null) {
        throw new ApiException('This operation is not allowed');
    }

    public function getItemPayload($optionGroup, $restaurantId = null)
    {
        $body = [];

        if (!is_null($optionGroup)) {
            $this->optionGroup = $optionGroup;
            if (!is_null($optionGroup->getName())) {
                $body['name'] = $this->optionGroup->getName();
            }
            if (!is_null($optionGroup->getIntegrationCode())) {
                $body['integrationCode'] = $this->optionGroup->getIntegrationCode();
            }
            if (!is_null($optionGroup->getIntegrationName())) {
                $body['integrationName'] = $this->optionGroup->getIntegrationName();
            }
            if (!is_null($optionGroup->getMaximumQuantity())) {
                $body['maximumQuantity'] = $this->optionGroup->getMaximumQuantity();
            }
            if (!is_null($optionGroup->getMinimumQuantity())) {
                $body['minimumQuantity'] = $this->optionGroup->getMinimumQuantity();
            }
            if (!is_null($optionGroup->getIndex())) {
                $body['index'] = $this->optionGroup->getIndex();
            }
            $body['product'] = [];
            if (!is_null($optionGroup->getProduct()->getIntegrationCode())) {
                $body['product']['integrationCode'] = $this->optionGroup->getProduct()->getIntegrationCode();
            }
            if (!is_null($restaurantId)) {
                $body['product']['partnerId'] = $restaurantId;
            }
        }
        return $body;
    }

    public function getItemRoute($menuItem)
    {
        return 'optionGroup';
    }

    public function getItemsRoute($optionGroup)
    {
        return 'optionGroup/productIntegrationCode/' . $optionGroup->getProduct()->getIntegrationCode();
    }

}
