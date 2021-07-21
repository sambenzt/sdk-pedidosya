<?php

namespace ReceptionSDK\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use ReceptionSDK\Exceptions\ConnectionException;
use Exception;

/**
 * HTTP generic REST client
 * @package ReceptionSDK\Http
 */
class Connection
{
    /**
     * @var Client client HTTP utility
     */
    private $httpClient;

    /**
     * Connection constructor.
     * @param String $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->httpClient = new Client([
            'base_uri' => $baseUrl,
            'http_errors' => false
        ]);
    }

    /**
     * Call a generic http GET
     * @param Request $request
     * @return Response
     * @throws ConnectionException
     */
    public function get(Request $request)
    {
        try {
            $res = $this->httpClient->request('GET', $request->getEndpoint(), [
                'query' => $request->getParameters(),
                'headers' => array_merge(
                    ['Content-Type' => 'application/json'],
                    $request->getHeaders()
                ),
                'connect_timeout' => $request->getTimeOut(),
                'read_timeout' => $request->getTimeOut(),
                'timeout' => $request->getTimeOut()
            ]);

            $response = new Response();
            $response->setContent($res->getBody());
            $response->setBody(json_decode($res->getBody()));
            $response->setStatusCode($res->getStatusCode());
            return $response;

        } catch (BadResponseException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode());
        } catch (ConnectionException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Call a generic http POST
     * @param Request $request
     * @return Response
     * @throws ConnectionException
     */
    public function post(Request $request)
    {
        try {
            $res = $this->httpClient->request('POST', $request->getEndpoint(), [
                'query' => $request->getParameters(),
                'body' => json_encode($request->getBody()),
                'headers' => array_merge(
                    ['Content-Type' => 'application/json'],
                    $request->getHeaders()
                ),
                'connect_timeout' => $request->getTimeOut(),
                'read_timeout' => $request->getTimeOut(),
                'timeout' => $request->getTimeOut()
            ]);

            $response = new Response();
            $response->setContent($res->getBody());
            $response->setBody(json_decode($res->getBody()));
            $response->setStatusCode($res->getStatusCode());
            return $response;

        } catch (BadResponseException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode());
        } catch (ConnectionException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Call a generic http PUT
     * @param Request $request
     * @return Response
     * @throws ConnectionException
     */
    public function put(Request $request)
    {
        try {
            $res = $this->httpClient->request('PUT', $request->getEndpoint(), [
                'query' => $request->getParameters(),
                'body' => json_encode($request->getBody()),
                'headers' => array_merge(
                    ['Content-Type' => 'application/json'],
                    $request->getHeaders()
                ),
                'connect_timeout' => $request->getTimeOut(),
                'read_timeout' => $request->getTimeOut(),
                'timeout' => $request->getTimeOut()
            ]);

            $response = new Response();
            $response->setContent($res->getBody());
            $response->setBody(json_decode($res->getBody()));
            $response->setStatusCode($res->getStatusCode());
            return $response;
        } catch (BadResponseException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode());
        } catch (ConnectionException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Call a generic http DELETE
     * @param Request $request
     * @return Response
     * @throws ConnectionException
     */
    public function delete(Request $request)
    {
        try {
            $res = $this->httpClient->request('DELETE', $request->getEndpoint(), [
                'query' => $request->getParameters(),
                'body' => json_encode($request->getBody()),
                'headers' => array_merge(
                    ['Content-Type' => 'application/json'],
                    $request->getHeaders()
                ),
                'connect_timeout' => $request->getTimeOut(),
                'read_timeout' => $request->getTimeOut(),
                'timeout' => $request->getTimeOut()
            ]);

            $response = new Response();
            $response->setContent($res->getBody());
            $response->setBody(json_decode($res->getBody()));
            $response->setStatusCode($res->getStatusCode());
            return $response;
        } catch (BadResponseException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode());
        } catch (ConnectionException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
