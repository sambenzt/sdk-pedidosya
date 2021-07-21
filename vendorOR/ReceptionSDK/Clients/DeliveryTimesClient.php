<?php

namespace ReceptionSDK\Clients;

use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Utils\PaginationOptions;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Request;
use Exception;

/**
 * A client for Delivery Times API.
 * @package ReceptionSDK\Clients
 */
class DeliveryTimesClient
{
    /**
     * @var ApiConnection
     */
    private $connection;

    /**
     * DeliveryTimesClient constructor.
     * Instantiate a new Delivery Times API Client
     * @param ApiConnection $connection
     */
    public function __construct(ApiConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Returns all the possible delivery times
     * @return array The list of delivery times
     * @internal param null|PaginationOptions $options
     */
    public function getAll()
    {
        return $this->getAllWithPagination();
    }

    private function getAllWithPagination(PaginationOptions $options = null)
    {
        try {
            $request = new Request();
            $request->setEndpoint('deliveryTimes');
            if (is_null($options)) {
                $options = PaginationOptions::create();
            }
            $request->setPagination($options);

            $response = $this->connection->get($request);
            if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                if (count($body->data)) {
                    return array_merge($body->data, $this->getAllWithPagination($options->next()));
                } else {
                    return array();
                }
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException(ErrorCode::$INTERNAL_SERVER_ERROR, 0, $e);
        }
    }

}