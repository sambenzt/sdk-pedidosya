<?php

namespace ReceptionSDK\Http;

use ReceptionSDK\Utils\PaginationOptions;

/**
 * API request data class
 * @package ReceptionSDK\Http
 */
class Request
{
    /**
     * Body of the request represented as a object
     * @var array
     */
    private $body;

    /**
     * Array of needed headers for the request
     * @var array
     */
    private $headers;

    /**
     * Array of needed parameters for the request
     * @var array
     */
    private $parameters;

    /**
     * Requests endpoint. Should be relative
     * @var string
     */
    private $endpoint;

    /**
     * Defined timeout of the request
     * @var int
     */
    private $timeOut;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->headers = [];
        $this->parameters = [];
        $this->timeOut = 10; // seconds
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param mixed $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return mixed
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @param mixed $timeOut
     */
    public function setTimeOut($timeOut)
    {
        $this->timeOut = $timeOut;
    }

    /**
     * Add new headers to the existing ones
     * @param $headers
     */
    public function addHeaders($headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    public function setPagination(PaginationOptions $options)
    {
        $pagination = array();
        $pagination['limit'] = $options->getLimit();
        $pagination['offset'] = $options->getOffset();
        $this->parameters = array_merge($this->parameters, $pagination);
    }

}