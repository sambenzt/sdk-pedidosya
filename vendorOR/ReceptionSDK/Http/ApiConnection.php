<?php

namespace ReceptionSDK\Http;

use Exception;
use ReceptionSDK\Exceptions\ApiException;
use ReceptionSDK\Exceptions\ErrorCode;
use ReceptionSDK\Helpers\SessionHelper;
use DateTime;
use DateTimeZone;

/**
 * Class ApiConnection
 * API REST client
 * @package ReceptionSDK\Http
 */
class ApiConnection
{
    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var int
     */
    private $tokenTimeOut = 60;

    /**
     * @var SessionHelper|null The session data handler.
     */
    private $sessionHelper;

    /**
     * @const string The name of the session variable that contains the api token.
     */
    private $API_TOKEN = 'token';

    /**
     * @const string The name of the session variable that contains the api token age.
     */
    private $API_TOKEN_AGE = 'tokenAge';

    /**
     * @const string The name of the session variable that contains the api token age.
     */
    private $restaurantId;

    /**
     * @const string The name of the session variable that contains the api token age.
     */
    private $iSmSUrl;

    /**
     * ApiConnection constructor.
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = new ApiCredentials($credentials);
        $this->API_TOKEN .= '_' . $this->credentials->getClientId();
        $this->API_TOKEN_AGE .= '_' . $this->credentials->getClientId();
        $this->connection = new Connection($this->url());
        $this->sessionHelper = new SessionHelper();
        $this->restaurantId = null;
        $this->iSmSUrl = $this->iSmSurl();
    }

    /**
     * Service access credentials
     * @return Credentials
     */
    public function credentials()
    {
        return $this->credentials;
    }

    /**
     * Service access restaurantId
     * @return int
     */
    public function restaurantId()
    {
        return $this->restaurantId;
    }

    /**
     * @param string $restaurantId
     */
    public function setRestaurantId($restaurantId)
    {
        $this->restaurantId = $restaurantId;
    }



    /**
     * Call a generic Api GET
     * @param Request $request
     * @return Response
     * @throws ApiException
     */
    public function get(Request $request)
    {
        try {
            $this->doAuthenticate();
            $request->addHeaders(['Authorization' => $this->sessionHelper->get($this->API_TOKEN)]);
            $response = $this->connection->get($request);
            if ($response->getStatusCode() == 403) {
                $this->invalidateCredentials();
            }
            return $response;
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Call a generic Api PUT
     * @param Request $request
     * @return Response
     * @throws ApiException
     */
    public function put(Request $request)
    {
        try {
            $this->doAuthenticate();
            $request->addHeaders(['Authorization' => $this->sessionHelper->get($this->API_TOKEN)]);
            $response = $this->connection->put($request);
            if ($response->getStatusCode() == 403) {
                $this->invalidateCredentials();
            }
            return $response;
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Call a generic Api DELETE
     * @param Request $request
     * @return Response
     * @throws ApiException
     */
    public function delete(Request $request)
    {
        try {
            $this->doAuthenticate();
            $request->addHeaders(['Authorization' => $this->sessionHelper->get($this->API_TOKEN)]);
            $response = $this->connection->delete($request);
            if ($response->getStatusCode() == 403) {
                $this->invalidateCredentials();
            }
            return $response;
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Call a generic Api POST
     * @param Request $request
     * @return Response
     * @throws ApiException
     */
    public function post(Request $request)
    {
        try {
            $this->doAuthenticate();
            $request->addHeaders(['Authorization' => $this->sessionHelper->get($this->API_TOKEN)]);
            $response = $this->connection->post($request);
            if ($response->getStatusCode() == 403) {
                $this->invalidateCredentials();
            }
            return $response;
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Make a request login against the API.
     * Remember to have valid credentials
     * @return boolean If can authenticate successfully
     * @throws ApiException If some error has occurred
     */
    public function authenticate()
    {
        try {
            $clientId = $this->credentials->getClientId();
            $clientSecret = $this->credentials->getClientSecret();

            $username = $this->credentials->getUsername();
            $password = $this->credentials->getPassword();

            $body = ['client_id' => $clientId, 'client_secret' => $clientSecret];
            if (isset($username) && strlen($username) > 0 && isset($password) && strlen($password) > 0) {
                $body['username'] = $username;
                $body['password'] = $password;
            }

            $request = new Request();
            $request->setBody($body);
            $request->setEndpoint('users/login');

            $response = $this->connection->post($request);
            if ($response->getStatusCode() == 200) {
                $json = $response->getBody();
                $push = $json->access->push;
                $restaurant = $json->restaurant;
                $pushAvailable = $push->available;
                $this->credentials = new ApiCredentials($this->credentials);
                if ($pushAvailable) {
                    $this->credentials->setOrderAccessKey($push->keyId);
                    $this->credentials->setOrderSecretKey($push->keySecret);
                    $this->credentials->setRegionEndpoint($push->region);
                    $this->credentials->setQueueName($push->queueName);
                }

                if (isset($username) && strlen($username) > 0 && isset($password) && strlen($password) > 0) {
                    $this->setRestaurantId($restaurant->id);
                }

                $this->sessionHelper->set($this->API_TOKEN, $json->access->token);
                $this->sessionHelper->set($this->API_TOKEN_AGE, new DateTime('now', new DateTimeZone('UTC')));
                return true;
            } else {
                throw ApiException::buildFromResponse($response);
            }
        } catch (ApiException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Check if the SDK is authenticated or not
     * @return boolean <code>true</code> if logged in
     */
    public function isAuthenticated()
    {
        return $this->sessionHelper->get($this->API_TOKEN) &&
            $this->sessionHelper->get($this->API_TOKEN_AGE);
    }

    private function doAuthenticate()
    {
        if (!$this->sessionHelper->get($this->API_TOKEN) ||
            !$this->sessionHelper->get($this->API_TOKEN_AGE)) {
            $this->authenticate();
        } else {
            $now = (new DateTime('now', new DateTimeZone('UTC')))->getTimestamp();
            $then = $this->sessionHelper->get($this->API_TOKEN_AGE)->getTimestamp();
            $timeOut = $this->tokenTimeOut;
            $diff = floor(($now - $then) / 60); // To minutes
            if ($diff > $timeOut) {
                $this->authenticate();
            }
        }
    }

    private function invalidateCredentials()
    {
        $this->sessionHelper->set($this->API_TOKEN, null);
        $this->sessionHelper->set($this->API_TOKEN_AGE, null);
    }

    private function url()
    {
        $prefix = '';
        if ($this->credentials->getEnvironment() != Environments::$PRODUCTION) {
            $prefix = 'stg-';
        }
        return "https://{$prefix}orders-api.pedidosya.com/v3/";
    }

    public function iSmSurl()
    {
        if ($this->credentials->getEnvironment() != Environments::$PRODUCTION) {
            $prefix = 'stg';
            return "https://{$prefix}-management-api.pedidosya.com/self-management/";
        }
        return "https://management-api.pedidosya.com/self-management/";
    }
}
