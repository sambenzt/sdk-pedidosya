<?php

namespace ReceptionSDK\Clients;

use ReceptionSDK\ApiClient;
use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Exceptions\NullArgumentException;
use ReceptionSDK\Helpers\Ensure;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Request;
use Exception;
use ReceptionSDK\Models\Product;
use ReceptionSDK\Utils\PaginationOptions;

/**
 * Class MenuItemClient
 * @package ReceptionSDK\Clients
 */
abstract class MenuItemClient
{
    /**
     * @var ApiConnection
     */
    protected $connection;

    /**
     * @var String
     */
    protected $itemUrl;


    /**
     * Instantiate a new Menu Item API client.
     * MenuItemClient constructor.
     * @param ApiConnection $connection
     * @param String $itemUrl
     */
    public function __construct(ApiConnection $connection, $itemUrl)
    {
        $this->connection = $connection;
        $this->itemUrl = $itemUrl;
    }

    public function getRestaurants()
    {
        try {
            $api = new ApiClient($this->connection->credentials());
            return $api->restaurant()->getAll(PaginationOptions::create());
        } catch (ApiException $ex) {
            throw new ApiException('No restaurants found');
        }
    }

    /**
     *  Create the entity with the specified restaurant code/id
     * @param $entity new menuItem to be created
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @return bool if the option was created
     * @throws ApiException if some error has occurred
     */

    public function create($entity, $restaurant = null)
    {
        $this->connection->authenticate();
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }
        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $restaurants = $this->getRestaurants();
            foreach ($restaurants as $res) {
                if($res->integrationCode == $restaurant) {
                    return $this->createItem($entity, $res->id);
                }
                throw new ApiException("Restaurant not Exists", 400, null, ErrorCode::$NOT_EXISTS);
            }
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            return $this->createItem($entity, $restaurant);
        } else {
            return $this->createItem($entity, $this->connection->restaurantId());
        }
    }

    /**
     * Modify the entity with the specified restaurant code/id
     * @param $entity $entity to be modified
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @return bool {bool} if the menuItem was modified
     * @throws ApiException if some error has occurred
     */

    public function modify($entity, $restaurant = null)
    {
        $this->connection->authenticate();
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }
        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $restaurants = $this->getRestaurants();
            foreach ($restaurants as $res) {
                if($res->integrationCode == $restaurant) {
                    return $this->modifyItem($entity, $res->id);
                }
                throw new ApiException("Restaurant not Exists", 400, null, ErrorCode::$NOT_EXISTS);
            }
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            return $this->modifyItem($entity, $restaurant);
        } else {
            return $this->modifyItem($entity, $this->connection->restaurantId());
        }
    }

    /**
     * Delete the entity with the specified restaurant code/id
     * @param $entity entity to be deleted
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @return bool {bool} if the menuItem was deleted
     * @throws ApiException if some error has occurred
     */
    public function delete($entity, $restaurant = null)
    {
        $this->connection->authenticate();
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }
        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $restaurants = $this->getRestaurants();
            foreach ($restaurants as $res) {
                if($res->integrationCode == $restaurant) {
                    return $this->deleteItem($entity, $res->id);
                }
                throw new ApiException("Restaurant not Exists", 400, null, ErrorCode::$NOT_EXISTS);
            }
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            return $this->deleteItem($entity, $restaurant);
        } else {
            return $this->deleteItem($entity, $this->connection->restaurantId());
        }
    }

    /**
     * Get all the menuItem with the specified restaurant code/id
     * @param restaurant restaurant code or restaurant id when using centralized keys
     * @return {menuItems} if the menuItems exists
     * @throws ApiException if some error has occurred
     */
    public function getAll($menuItem = null, $restaurant = null)
    {
        $this->connection->authenticate();
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }
        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $restaurants = $this->getRestaurants();
            foreach ($restaurants as $res) {
                if($res->integrationCode == $restaurant) {
                    return $this->getAllItems($menuItem, $res->id);
                }
                throw new ApiException("Restaurant not Exists", 400, null, ErrorCode::$NOT_EXISTS);
            }
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            return $this->getAllItems($menuItem, $restaurant);
        } else {
            return $this->getAllItems($menuItem, $this->connection->restaurantId());
        }
    }

    /**
   * Get the menuItem by id with the specified restaurant code/id
   * @param menuItem menuItem to get
   * @param restaurant restaurant code or restaurant id when using centralized keys
   * @return {menuItem} if the menuItems exists
   * @throws ApiException if some error has occurred
   */
    public function getByName($menuItem, $restaurant = null)
    {
        $this->connection->authenticate();
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant))
        {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }
        if (is_string($restaurant))
        {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $restaurants = $this->getRestaurants();
            foreach ($restaurants as $res) {
                if ($res->integrationCode == $restaurant) {
                    return $this->getItemByName($menuItem, $res->id);
                }
                throw new ApiException("Restaurant not Exists", 400, null, ErrorCode::$NOT_EXISTS);
            }
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            return $this->getItemByName($menuItem, $restaurant);
        } else {
            return $this->getItemByName($menuItem, $this->connection->restaurantId());
        }
    }

    /**
   * Get the menuItem by integrationCode
   * @param menuItem menuItem to get
   * @param restaurant restaurant code or restaurant id when using centralized keys
   * @return {menuItem} if the menuItems exists
   * @throws ApiException if some error has occurred
   */
    public function getByIntegrationCode($menuItem, $restaurant = null)
    {
        $this->connection->authenticate();
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant))
        {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }
        if (is_string($restaurant))
        {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $restaurants = $this->getRestaurants();
            foreach ($restaurants as $res) {
                if ($res->integrationCode == $restaurant) {
                    return $this->getItemByIntegrationCode($menuItem, $res->id);
                }
                throw new ApiException("Restaurant not Exists", 400, null, ErrorCode::$NOT_EXISTS);
            }
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            return $this->getItemByIntegrationCode($menuItem, $restaurant);
        } else {
            return $this->getItemByIntegrationCode($menuItem, $this->connection->restaurantId());
        }
    }

    /**
     * Get all the $schedule with the specified restaurant code/id
     * @param $schedule $schedule to get
     * @param restaurant restaurant code or restaurant id when using centralized keys
     * @return {scheduleItem} if the scheduleItem exists
     * @throws ApiException if some error has occurred
     */
    public function getAllSchedules($schedule, $restaurant = null)
    {
        $this->connection->authenticate();
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant))
        {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }
        if (is_string($restaurant))
        {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $restaurants = $this->getRestaurants();
            foreach ($restaurants as $res) {
                if ($res->integrationCode == $restaurant) {
                    return $this->getAllItemSchedules($schedule, $res->id);
                }
                throw new ApiException("Restaurant not Exists", 400, null, ErrorCode::$NOT_EXISTS);
            }
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            return $this->getAllItemSchedules($schedule, $restaurant);
        } else {
            return $this->getAllItemSchedules($schedule, $this->connection->restaurantId());
        }
    }

    /**
     * Create the scheduleItem with the specified restaurant code/id
     * @param $schedule new $schedule to be created
     * @param restaurant restaurant code or restaurant id when using centralized keys
     * @return {scheduleItem} if the $schedule was created
     * @throws ApiException if some error has occurred
     */
    public function createSchedule($schedule, $restaurant = null)
    {
        $this->connection->authenticate();
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant))
        {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }
        if (is_string($restaurant))
        {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $restaurants = $this->getRestaurants();
            foreach ($restaurants as $res) {
                if ($res->integrationCode == $restaurant) {
                    return $this->createItemSchedule($schedule, $res->id);
                }
                throw new ApiException("Restaurant not Exists", 400, null, ErrorCode::$NOT_EXISTS);
            }
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            return $this->createItemSchedule($schedule, $restaurant);
        } else {
            return $this->createItemSchedule($schedule, $this->connection->restaurantId());
        }
    }

    /**
     * Delete the $schedule with the specified restaurant code/id
     * @param $schedule $schedule to be deleted
     * @param restaurant restaurant code or restaurant id when using centralized keys
     * @return {boolean} if the $schedule was deleted
     * @throws ApiException if some error has occurred
     */
    public function deleteSchedule($schedule, $restaurant = null)
    {
        $this->connection->authenticate();
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant))
        {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }
        if (is_string($restaurant))
        {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $restaurants = $this->getRestaurants();
            foreach ($restaurants as $res) {
                if ($res->integrationCode == $restaurant) {
                    return $this->deleteItemSchedule($schedule, $res->id);
                }
                throw new ApiException("Restaurant not Exists", 400, null, ErrorCode::$NOT_EXISTS);
            }
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            return $this->deleteItemSchedule($schedule, $restaurant);
        } else {
            return $this->deleteItemSchedule($schedule, $this->connection->restaurantId());
        }
    }

    private function createItem($menuItem, $restaurantId = null)
    {
        try {
            $request = new Request();
            $request->setEndpoint($this->connection->iSmSurl() . $this->getItemRoute($menuItem));
            $request->setTimeOut(120);
            $request->addHeaders(['Peya-Partner-Id' => $restaurantId]);

            $body = $this->getItemPayload($menuItem, $restaurantId);

            $request->setBody($body);
            $response = $this->connection->post($request);
            if ($response->getStatusCode() == 200) {
                return $response->getBody();
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    private function modifyItem($menuItem, $restaurantId = null)
    {
        try {
            $request = new Request();
            $request->setEndpoint($this->connection->iSmSurl() . $this->getItemRoute($menuItem));
            $request->setTimeOut(120);
            $request->addHeaders(['Peya-Partner-Id' => $restaurantId]);

            $body = $this->getItemPayload($menuItem, $restaurantId);

            $request->setBody($body);
            $response = $this->connection->put($request);
            if ($response->getStatusCode() == 200) {
                return $response->getBody();
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    private function deleteItem($menuItem, $restaurantId = null)
    {
        try {
            $request = new Request();
            $request->setEndpoint($this->connection->iSmSurl() . $this->getItemRoute($menuItem));
            $request->setTimeOut(120);
            $request->addHeaders(['Peya-Partner-Id' => $restaurantId]);

            $body = $this->getItemPayload($menuItem, $restaurantId);

            $request->setBody($body);
            $response = $this->connection->delete($request);
            if ($response->getStatusCode() == 200) {
                return true;
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    private function getAllItems($menuItem = null, $restaurantId)
    {
        try {
            $request = new Request();
            $request->setEndpoint($this->connection->iSmSurl() . $this->getItemsRoute($menuItem));
            $request->addHeaders(['Peya-Partner-Id' => $restaurantId]);
            $request->setTimeOut(1000000);
            $response = $this->connection->get($request);
            if ($response->getStatusCode() == 200) {
                return $response->getBody()->data;
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    private function getItemByName($menuItem, $restaurantId)
    {
        try {
            $request = new Request();
            $request->setEndpoint($this->connection->iSmSurl() . $this->getItemsRoute($menuItem)
                . '/name/' . $menuItem->getName());
            $request->addHeaders(['Peya-Partner-Id' => $restaurantId]);
            $request->setTimeOut(1000000);
            $response = $this->connection->get($request);
            if ($response->getStatusCode() == 200) {
                return $response->getBody();
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    private function getItemByIntegrationCode($menuItem, $restaurantId)
    {
        try {
            $request = new Request();
            $request->setEndpoint($this->connection->iSmSurl() . $this->getItemsRoute($menuItem)
                . '/integrationCode/' . $menuItem->getIntegrationCode());
            $request->addHeaders(['Peya-Partner-Id' => $restaurantId]);
            $request->setTimeOut(1000000);
            $response = $this->connection->get($request);
            if ($response->getStatusCode() == 200) {
                return $response->getBody();
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    private function getAllItemSchedules($scheduleItem , $restaurantId)
    {
        try {
            $request = new Request();
            $request->setEndpoint($this->connection->iSmSurl() . $this->getSchedulesRoute($scheduleItem));
            $request->addHeaders(['Peya-Partner-Id' => $restaurantId]);
            $request->setTimeOut(1000000);
            $response = $this->connection->get($request);
            if ($response->getStatusCode() == 200) {
                return $response->getBody()->data;
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    private function createItemSchedule($scheduleItem , $restaurantId)
    {
        try {
            $request = new Request();
            $request->setEndpoint($this->connection->iSmSurl() . $this->getItemRoute($scheduleItem) . '/schedule');
            $request->addHeaders(['Peya-Partner-Id' => $restaurantId]);
            $request->setTimeOut(1000000);
            $body = $this->getItemSchedulePayload($scheduleItem, $restaurantId);
            $request->setBody($body);
            $response = $this->connection->post($request);
            if ($response->getStatusCode() == 200) {
                return $response->getBody();
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    private function deleteItemSchedule($scheduleItem , $restaurantId)
    {
        try {
            $request = new Request();
            $request->setEndpoint($this->connection->iSmSurl() . $this->getItemRoute($scheduleItem) . '/schedule');
            $request->addHeaders(['Peya-Partner-Id' => $restaurantId]);
            $request->setTimeOut(1000000);
            $body = $this->getItemSchedulePayload($scheduleItem, $restaurantId);
            $request->setBody($body);
            $response = $this->connection->delete($request);
            if ($response->getStatusCode() == 200) {
                return true;
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    protected function getItemRoute($menuItem)
    {
        return '';
    }

    protected function getItemsRoute($menuItem)
    {
        return '';
    }

    protected function getItemPayload($menuItem, $restaurantId)
    {
        return '';
    }

    public function getSchedulesRoute($scheduleItem)
    {
        return '';
    }

    protected function getItemSchedulePayload($scheduleItem, $restaurantId)
    {
        return '';
    }
}
