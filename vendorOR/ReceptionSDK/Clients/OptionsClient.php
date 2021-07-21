<?php

namespace ReceptionSDK\Clients;

use ReceptionSDK\ApiClient;
use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Helpers\Ensure;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Request;
use ReceptionSDK\Models\Option;
use ReceptionSDK\Utils\PaginationOptions;

/**
 * Class OptionsClient
 * A client for Options API.
 * @package ReceptionSDK\Clients
 */
class OptionsClient extends MenuItemClient
{
    /**
     * OptionsClient constructor.
     * Instantiate a new Options API client.
     * @param ApiConnection $connection
     */
    public function __construct($connection)
    {
        Ensure::argumentNotNull($connection, 'connection');
        parent::__construct($connection, 'options');
    }

    public function getByName($option, $restaurantId = null) {
        throw new ApiException('This operation is not allowed');
    }

    public function getByIntegrationCode($option, $restaurantId = null) {
        throw new ApiException('This operation is not allowed');
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

    public function getItemPayload($option, $restaurantId = null)
    {

        $body = [];

        if (!is_null($option)) {
            $this->option = $option;
            $body['optionGroup'] = [];
            $body['optionGroup']['product'] = [];

            if (!is_null($option->getName())) {
                $body['name'] = $this->option->getName();
            }
            if (!is_null($option->getIntegrationCode())) {
                $body['integrationCode'] = $this->option->getIntegrationCode();
            }
            if (!is_null($option->getIntegrationName())) {
                $body['integrationName'] = $this->option->getIntegrationName();
            }
            if (!is_null($option->getPrice())) {
                $body['price'] = $this->option->getPrice();
            }
            if (!is_null($option->getEnabled())) {
                $body['enabled'] = $this->option->getEnabled();
            }
            if (!is_null($option->getQuantity())) {
                $body['quantity'] = $this->option->getQuantity();
            }
            if (!is_null($option->getIndex())) {
                $body['index'] = $this->option->getIndex();
            }
            if (!is_null($option->getModifiesPrice())) {
                $body['modifiesPrice'] = $this->option->getModifiesPrice();
            }
            if (!is_null($option->getRequiresAgeCheck())) {
                $body['requiresAgeCheck'] = $this->option->getRequiresAgeCheck();
            }

            if (!is_null($option->getOptionGroup()->getIntegrationCode())) {
                $body['optionGroup']['integrationCode'] = $this->option->getOptionGroup()->getIntegrationCode();
            }
            if (!is_null($option->getOptionGroup()->getIntegrationName())) {
                $body['optionGroup']['integrationName'] = $this->option->getOptionGroup()->getIntegrationName();
            }
            if (!is_null($option->getOptionGroup()->getName())) {
                $body['optionGroup']['name'] = $this->option->getOptionGroup()->getName();
            }

            if (!is_null($option->getOptionGroup()->getProduct()->getIntegrationCode())) {
                $body['optionGroup']['product']['integrationCode'] = $this->option->getOptionGroup()->getProduct()->getIntegrationCode();
            }
            if (!is_null($restaurantId)) {
                $body['optionGroup']['product']['partnerId'] = $restaurantId;
            }


        }
        return $body;
    }

    public function getItemRoute($menuItem)
    {
        return 'option';
    }

    public function getItemsRoute($option)
    {
        return 'option/product/' . $option->getOptionGroup()->getProduct()->getIntegrationCode() .
            '/optionGroup/' . $option->getOptionGroup()->getIntegrationCode();
    }

}
