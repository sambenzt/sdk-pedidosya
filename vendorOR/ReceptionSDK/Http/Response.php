<?php

namespace ReceptionSDK\Http;

/**
 * API response data class
 * @package ReceptionSDK\Http
 */
class Response
{
    /**
     * HTTP status code
     * @var int
     */
    private $statusCode;

    /**
     * Object representation of the body of the response
     * @var \stdClass
     */
    private $body;

    /**
     * Raw body response
     * @var string JSON
     */
    private $content;

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->statusCode = 500;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
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
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

}