<?php

namespace ReceptionSDK\Clients;

use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Exceptions\NullArgumentException;
use ReceptionSDK\Helpers\Ensure;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Request;
use Exception;

/**
 * Class EventsClient
 * A client for Events API.
 * @package ReceptionSDK\Clients
 */
class EventsClient
{

    /*
     * Sdk version, used to send with initialization event
     */
    private static $version = '1.8.2';

    /**
     * @var ApiConnection
     */
    private $connection;

    /**
     * EventsClient constructor.
     * Instantiate a new Events API client.
     * @param ApiConnection $connection
     */
    public function __construct(ApiConnection $connection)
    {
        Ensure::argumentNotNull($connection, 'connection');

        $this->connection = $connection;
    }

    /**
     * Register a new initialization event.
     * This event represents the startup of the reception system.
     * @param array $version a key value array with all possible information about the device and reception app
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @throws ApiException if some error has occurred
     */
    public function initialization($version, $restaurant = null)
    {
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }

        if (is_array($version)) {
            $version['sdk'] = 'php-' . self::$version;
        }

        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $this->sendInitialization($version, null, $restaurant);
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            $this->sendInitialization($version, $restaurant);
        } else {
            $this->sendInitialization($version);
        }
    }

    /**
     * Register a new heart beat event.
     * This event represents that the reception system it's alive and ready to receive orders.
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @throws ApiException if some error has occurred
     */
    public function heartBeat($restaurant = null)
    {
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }

        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $this->sendHeartBeat(null, $restaurant);
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            $this->sendHeartBeat($restaurant);
        } else {
            $this->sendHeartBeat();
        }
    }

    /**
     * Register a reception event.
     * This event represents that the order has arrived.
     * @param int $orderId id of the order that has been received.
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @throws ApiException if some error has occurred
     */
    public function reception($orderId, $restaurant = null)
    {
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }

        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $this->sendReception($orderId, null, $restaurant);
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            $this->sendReception($orderId, $restaurant);
        } else {
            $this->sendReception($orderId);
        }
    }

    /**
     * Register an order acknowledgement event
     * This event represents the order was seen by a restaurant operator
     * @param int $orderId id of the order that has been received.
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @throws ApiException if some error has occurred
     */
    public function acknowledgement($orderId, $restaurant = null)
    {
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }

        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $this->sendAcknowledgement($orderId, null, $restaurant);
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            $this->sendAcknowledgement($orderId, $restaurant);
        } else {
            $this->sendAcknowledgement($orderId);
        }
    }

    /**
     * Register a order state change event
     * This event represents that a state change of the order must be done
     * @param int $orderId id of the order that has been received.
     * @param string $orderState new state of the order
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @throws ApiException if some error has occurred
     */
    public function stateChange($orderId, $orderState, $restaurant = null)
    {
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }

        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $this->sendStateChange($orderId, $orderState, null, $restaurant);
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            $this->sendStateChange($orderId, $orderState, $restaurant);
        } else {
            $this->sendStateChange($orderId, $orderState);
        }
    }

    /**
     * Register a warning event.
     * This event represents a warning, for example: low battery, lack of paper, etc.
     * @param string $eventCode code of the event
     * @param string $eventDescription a brief description of the event
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @throws ApiException if some error has occurred
     */
    public function warning($eventCode, $eventDescription, $restaurant = null)
    {
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }

        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $this->sendWarning($eventCode, $eventDescription, null, $restaurant);
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            $this->sendWarning($eventCode, $eventDescription, $restaurant);
        } else {
            $this->sendWarning($eventCode, $eventDescription);
        }
    }

    /**
     * Register an error event.
     * This event represents a error, for example: missing product code, can't confirm order, error processing orders.
     * @param string $eventCode code of the event
     * @param string $eventDescription a brief description of the event
     * @param null $restaurant restaurant id or restaurant code when using centralized keys
     * @throws ApiException if some error has occurred
     */
    public function error($eventCode, $eventDescription, $restaurant = null)
    {
        if ($this->connection->credentials()->centralizedKeys() && is_null($restaurant)) {
            throw new NullArgumentException('You must specify a restaurantCode or restaurantId');
        }

        if (is_string($restaurant)) {
            Ensure::argumentNotNullOrEmptyString($restaurant, 'restaurant');
            $this->sendError($eventCode, $eventDescription, null, $restaurant);
        } else if (is_integer($restaurant)) {
            Ensure::greaterThanZero($restaurant, 'restaurant');
            $this->sendError($eventCode, $eventDescription, $restaurant);
        } else {
            $this->sendError($eventCode, $eventDescription);
        }
    }

    private function sendInitialization($version, $restaurantId = null, $restaurantCode = null)
    {
        $data = [
            'version' => urldecode(http_build_query(is_array($version) ? $version : [], '', '|')),
            'restaurant' => [],
            'action' => 'INITIALIZATION'
        ];
        if (!is_null($restaurantId)) {
            $data['restaurant']['id'] = $restaurantId;
        }
        if (!is_null($restaurantCode)) {
            $data['restaurant']['code'] = trim($restaurantCode);
        }
        $this->event($data);
    }

    private function sendHeartBeat($restaurantId = null, $restaurantCode = null)
    {
        $data = [
            'restaurant' => [],
            'action' => 'HEART_BEAT'
        ];
        if (!is_null($restaurantId)) {
            $data['restaurant']['id'] = $restaurantId;
        }
        if (!is_null($restaurantCode)) {
            $data['restaurant']['code'] = trim($restaurantCode);
        }
        $this->event($data);
    }

    private function sendReception($orderId, $restaurantId = null, $restaurantCode = null)
    {
        $data = [
            'order' => $orderId,
            'restaurant' => [],
            'action' => 'RECEPTION'
        ];
        if (!is_null($restaurantId)) {
            $data['restaurant']['id'] = $restaurantId;
        }
        if (!is_null($restaurantCode)) {
            $data['restaurant']['code'] = trim($restaurantCode);
        }
        $this->event($data);
    }

    private function sendAcknowledgement($orderId, $restaurantId = null, $restaurantCode = null)
    {
        $data = [
            'order' => $orderId,
            'restaurant' => [],
            'action' => 'ACKNOWLEDGEMENT'
        ];
        if (!is_null($restaurantId)) {
            $data['restaurant']['id'] = $restaurantId;
        }
        if (!is_null($restaurantCode)) {
            $data['restaurant']['code'] = trim($restaurantCode);
        }
        $this->event($data);
    }

    private function sendStateChange($orderId, $orderState, $restaurantId = null, $restaurantCode = null)
    {
        $data = [
            'order' => $orderId,
            'state' => $orderState,
            'restaurant' => [],
            'action' => 'STATE_CHANGE'
        ];
        if (!is_null($restaurantId)) {
            $data['restaurant']['id'] = $restaurantId;
        }
        if (!is_null($restaurantCode)) {
            $data['restaurant']['code'] = trim($restaurantCode);
        }
        $this->event($data);
    }

    private function sendWarning($eventCode, $eventDescription, $restaurantId = null, $restaurantCode = null)
    {
        $data = [
            'event' => $eventCode,
            'description' => $eventDescription,
            'restaurant' => [],
            'action' => 'WARNING'
        ];
        if (!is_null($restaurantId)) {
            $data['restaurant']['id'] = $restaurantId;
        }
        if (!is_null($restaurantCode)) {
            $data['restaurant']['code'] = trim($restaurantCode);
        }
        $this->event($data);
    }

    private function sendError($eventCode, $eventDescription, $restaurantId = null, $restaurantCode = null)
    {
        $data = [
            'event' => $eventCode,
            'description' => $eventDescription,
            'restaurant' => [],
            'action' => 'ERROR'
        ];
        if (!is_null($restaurantId)) {
            $data['restaurant']['id'] = $restaurantId;
        }
        if (!is_null($restaurantCode)) {
            $data['restaurant']['code'] = trim($restaurantCode);
        }
        $this->event($data);
    }

    private function event($data)
    {
        try {
            $request = new Request();
            $request->setEndpoint('events');
            $request->setBody($data);

            $response = $this->connection->post($request);
            if ($response->getStatusCode() != 200) {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }
}
