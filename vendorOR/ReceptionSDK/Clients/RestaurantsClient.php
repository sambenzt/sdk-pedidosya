<?php

namespace ReceptionSDK\Clients;

use Exception;
use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Helpers\Ensure;
use ReceptionSDK\Utils\PaginationOptions;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Request;
use ReceptionSDK\Models\RestaurantState;

class RestaurantsClient
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
     * Returns all the possible restaurants inside the pagination defined
     * @param PaginationOptions $options
     * @param string $code
     * @return array The list of restaurants
     * @throws ApiException if some error has occurred
     */
    public function getAll(PaginationOptions $options, $code = '')
    {
        try {
            $request = new Request();
            $request->setEndpoint('restaurants');
            if (!empty($code)) {
                $request->setParameters(['code' => $code]);
            }
            $request->setPagination($options);

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

    /**
     * Close a restaurant with a date range in restaurant's country timezone
     * @param $id
     * @param $from
     * @param $to
     * @param $reason
     * @return mixed
     * @throws ApiException
     */
    public function close($id, $from, $to, $reason)
    {
        Ensure::greaterThanZero($id, 'id');
        Ensure::validDateFormat($from, 'from');
        Ensure::validDateFormat($to, 'to');
        Ensure::firstDateBeforeSecond($from, $to, 'from', 'to');
        Ensure::argumentNotNullOrEmptyString($reason, 'reason');

        $state = RestaurantState::$OFFLINE;
        $from = self::convertDateToApiFormat($from);
        $to = self::convertDateToApiFormat($to);

        $body = compact('state', 'from', 'to', 'reason');

        $request = new Request();
        $request->setEndpoint("restaurants/$id");
        $request->setBody($body);

        $response = $this->connection->put($request);
        if ($response->getStatusCode() == 200) {
            return $response->getBody();
        } else {
            throw ApiException::buildFromResponse($response);
        }
    }

    /**
     * Open a restaurant from a date (previously closed with the close operation)
     * @param $id
     * @param $from
     * @return mixed
     * @throws ApiException
     */
    public function open($id, $from)
    {
        Ensure::greaterThanZero($id, 'restaurantId');
        Ensure::validDateFormat($from, 'from');

        $state = RestaurantState::$ONLINE;
        $from = self::convertDateToApiFormat($from);

        $body = compact('state', 'from');

        $request = new Request();
        $request->setEndpoint("restaurants/$id");
        $request->setBody($body);

        $response = $this->connection->put($request);
        if ($response->getStatusCode() == 200) {
            return $response->getBody();
        } else {
            throw ApiException::buildFromResponse($response);
        }
    }

    private static function convertDateToApiFormat($date)
    {
        $explodedDate = explode(' ', $date);
        return $explodedDate[0]. 'T' . $explodedDate[1] . 'Z';
    }

}