<?php

namespace ReceptionSDK\Clients;

use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Utils\PaginationOptions;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Request;
use Exception;

class RejectMessagesClient
{
    /**
     * @var ApiConnection
     */
    private $connection;

    /**
     * RejectMessagesClient constructor.
     * Instantiate a new Reject Messages API client.
     * @param ApiConnection $connection
     */
    public function __construct(ApiConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Returns all the possible reject messages
     * @return array The list of reject messages
     * @throws ApiException if some error has occurred
     */
    public function getAll()
    {
        return $this->getAllWithPagination();
    }

    private function getAllWithPagination(PaginationOptions $options = null)
    {
        try {
            $request = new Request();
            $request->setEndpoint('rejectMessages');
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