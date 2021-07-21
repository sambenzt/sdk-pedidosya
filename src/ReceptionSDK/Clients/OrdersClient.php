<?php

namespace ReceptionSDK\Clients;

use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Helpers\Ensure;
use ReceptionSDK\Utils\PaginationOptions;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\ApiCredentials;
use ReceptionSDK\Http\Request;
use Exception;
use ReceptionSDK\Models\OrderState;

/**
 * A client for Orders API.
 * @package ReceptionSDK\Clients
 */
class OrdersClient
{
    /**
     * @var int Last obtained order id
     */
    private $timestamp = 0;

    /**
     * @var ApiConnection
     */
    private $connection;

    /**
     * @var int
     */
    private static $WAIT_TIME_SECONDS = 20;

    /**
     * @var int
     */
    private static $POLL_TIME_SECONDS = 10;

    /**
     * @var int
     */
    private static $MAX_RETRIES = 5;

    /**
     * @var int
     */
    private static $MAX_NUMBER_OF_MESSAGES = 10;

    /**
     * @var int
     */
    private static $CONFIRM = 2;

    /**
     * @var int
     */
    private static $REJECT = 3;

    /**
     * @var DeliveryTimesClient
     */
    private $deliveryTime;

    /**
     * @var RejectMessagesClient
     */
    private $rejectMessage;

    /**
     * OrdersClient constructor.
     * @param ApiConnection $connection
     */
    public function __construct(ApiConnection $connection)
    {
        $this->connection = $connection;
        $this->deliveryTime = new DeliveryTimesClient($this->connection);
        $this->rejectMessage = new RejectMessagesClient($this->connection);
    }

    /**
     * Client for the DeliveryTimes API
     * @return DeliveryTimesClient
     */
    public function deliveryTime()
    {
        return $this->deliveryTime;
    }

    /**
     * Client for the RejectMessages API
     * @return RejectMessagesClient
     */
    public function rejectMessage()
    {
        return $this->rejectMessage;
    }

    /**
     * Returns an operational order by it's id
     * @param $id
     * @return mixed
     * @throws ApiException
     */
    public function get($id)
    {
        try {
            $request = new Request();
            $request->setEndpoint("orders/$id");

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

    /**
     * Listen for new orders. This will return new and orders updates
     * @param $state
     * @param $onSuccess
     * @param $onError
     * @param PaginationOptions $options
     * @return array
     * @throws ApiException
     */
    public function getAll($state, PaginationOptions $options, $onSuccess = null, $onError = null)
    {
        $apiCredentials = new ApiCredentials($this->connection->credentials());
        if (!$this->connection->isAuthenticated()) {
            $this->connection->authenticate();
        }
        if ($state != OrderState::$PENDING && !$options instanceof PaginationOptions) {
            throw new \InvalidArgumentException('$options is mandatory for a state different to PENDING');
        }
        if ($apiCredentials->pushAvailable()) {
            if ($state == OrderState::$PENDING) {
                throw new ApiException('Cannot get PENDING orders from this method using this kind of credentials');
            } else {
                throw new ApiException('Not available - to be implemented');
                // return $this->pushOrders();
            }
        } else {
            if (is_callable($onSuccess) && is_callable($onError)) {
                $this->pollOrders($onSuccess, $onError, $options);
            } else {
                return $this->loadOrders($state, $options);
            }
        }
    }

    /**
     * Confirm a pending order. This method must be called when the restaurant accepts the order.
     * @param $order
     * @param $deliveryTime
     * @return bool
     */
    public function confirm($order, $deliveryTime = null)
    {
        $orderId = is_numeric($order) ? $order : $order->id;
        $deliveryTimeId = 0;
        if (!is_null($deliveryTime)) {
            $deliveryTimeId = is_numeric($deliveryTime) ? $deliveryTime : $deliveryTime->id;
        }

        return $this->update($orderId, self::$CONFIRM, $deliveryTimeId, 0, false, null);
    }

    /**
     * Reject a pending order. This method must be called when the restaurant cannot accept the order.
     * @param $order
     * @param $rejectMessage
     * @param null $rejectNote
     * @return bool
     */
    public function reject($order, $rejectMessage, $rejectNote = null)
    {
        $orderId = is_numeric($order) ? $order : $order->id;
        $rejectMessageId = is_numeric($rejectMessage) ? $rejectMessage : $rejectMessage->id;

        return $this->update($orderId, self::$REJECT, 0, $rejectMessageId, false, $rejectNote);
    }

    /**
     * Dispatch an order. This method must be called when the restaurant is ready to deliver the order.
     * @param $order
     * @return bool
     */
    public function dispatch($order)
    {
        $orderId = is_numeric($order) ? $order : $order->id;

        return $this->update($orderId, 0, 0, 0, true, null);
    }

    /**
     * Retrieves the tracking for logistic orders
     * @param $orderId
     * @return mixed
     * @throws ApiException
     */
    public function tracking($orderId)
    {
        try {
            Ensure::greaterThanZero($orderId, 'orderId');

            $request = new Request();
            $request->setEndpoint("orders/$orderId/tracking");

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

    private function update($id, $state, $deliveryTimeId, $rejectMessageId, $dispatched, $rejectNote)
    {
        try {
            $request = new Request();
            $request->setEndpoint("orders/$id");

            $body = [];
            if ($dispatched) {
                $body['dispatched'] = true;
            } else {
                $body = ['state' => $state];
                if ($state == self::$CONFIRM) {
                    if ($deliveryTimeId) {
                        $body['deliveryTimeId'] = $deliveryTimeId;
                    }
                } else if ($state == self::$REJECT) {
                    $body['rejectMessageId'] = $rejectMessageId;
                    if (!is_null($rejectNote)) {
                        $body['notes'] = $rejectNote;
                    }
                }
            }
            $request->setBody($body);

            $response = $this->connection->put($request);
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

    private function pushOrders()
    {
        // TODO: TO BE IMPLEMENTED
        return [];
    }

    private function pollOrders($onSuccess, $onError, PaginationOptions $options)
    {
        try {
            $orders = $this->loadOrders(OrderState::$PENDING,  $options);
            foreach ($orders as $order) {
                $onSuccess($order);
            }
        } catch (ApiException $e) {
            $onError($e);
        } catch (Exception $e) {
            $onError(new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e));
        }
    }

    private function loadOrders($state, PaginationOptions $options)
    {
        try {
            $pendingState = ($state == OrderState::$PENDING);
            $request = new Request();
            $request->setEndpoint('orders');
            if ($pendingState) {
                $request->setParameters(['timestamp' => $this->timestamp]);
            } else {
                $request->setParameters(['state' => $state]);
            }
            $request->setPagination($options);

            $response = $this->connection->get($request);
            if ($response->getStatusCode() == 200) {
                $orders = $response->getBody()->data;
                if ($pendingState && count($orders)) {
                    $this->timestamp = $this->max($orders);
                }
                return $orders;
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

    private function max($orders)
    {
        $timestamps = [];
        foreach ($orders as $order) {
            $timestamps[] = $order->timestamp;
        }
        return max($timestamps);
    }

}