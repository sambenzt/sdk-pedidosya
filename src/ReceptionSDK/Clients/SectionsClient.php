<?php

namespace ReceptionSDK\Clients;

use ReceptionSDK\ApiClient;
use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Helpers\Ensure;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Request;
use ReceptionSDK\Models\OptionGroup;
use ReceptionSDK\Models\Section;
use ReceptionSDK\Utils\PaginationOptions;

/**
 * Class SectionsClient
 * A client for Sections API.
 * @package ReceptionSDK\Clients
 */
class SectionsClient extends MenuItemClient
{
    /**
     * SectionsClient constructor.
     * Instantiate a new Sections API client.
     * @param ApiConnection $connection
     */
    public function __construct($connection)
    {
        Ensure::argumentNotNull($connection, 'connection');
        parent::__construct($connection, 'section');
    }

    public function getItemPayload($section, $restaurantId = null)
    {
        $body = [];

        if (!is_null($section)) {
            $this->section = $section;
            if (!is_null($restaurantId)) {
                $body['partnerId'] = $restaurantId;
            }
            if (!is_null($section->getName())) {
                $body['name'] = $this->section->getName();
            }
            if (!is_null($section->getIntegrationCode())) {
                $body['integrationCode'] = $this->section->getIntegrationCode();
            }
            if (!is_null($section->getIndex())) {
                $body['index'] = $this->section->getIndex();
            }
            if (!is_null($section->getEnabled())) {
                $body['enabled'] = $this->section->getEnabled();
            }
            if (!is_null($this->section->getIntegrationName())) {
                $body['integrationName'] = $this->section->getIntegrationName();
            }
        }
        return $body;
    }

    public function getItemSchedulePayload($scheduleItem, $restaurantId)
    {
        $body = [];

        if (!is_null($scheduleItem)) {
            $this->schedule = $scheduleItem;
            if (!is_null($restaurantId)) {
                $body['partnerId'] = $restaurantId;
            }
            if (!is_null($scheduleItem->getEntity()->getName())) {
                $body['section']['name'] = $this->schedule->getEntity()->getName();
            }
            if (!is_null($scheduleItem->getEntity()->getIntegrationCode())) {
                $body['section']['integrationCode'] = $this->schedule->getEntity()->getIntegrationCode();
            }
            if (!is_null($scheduleItem->getFrom())) {
                $body['from'] = $this->schedule->getFrom();
            }
            if (!is_null($scheduleItem->getTo())) {
                $body['to'] = $this->schedule->getTo();
            }
            if (!is_null($scheduleItem->getDay())) {
                $body['day'] = $this->schedule->getDay();
            }
        }
        return $body;
    }

    public function getItemRoute($menuItem)
    {
        return 'section';
    }

    public function getItemsRoute($menuItem)
    {
        return 'section';
    }

    public function getAll($menuItem = null, $restaurant = null)
    {
        return parent::getAll(null,$restaurant);
    }

    public function getSchedulesRoute($scheduleItem)
    {
        return 'section/name/' . $scheduleItem->getEntity()->getName() . '/schedule';
    }


}
