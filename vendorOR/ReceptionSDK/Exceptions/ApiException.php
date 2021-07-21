<?php

namespace ReceptionSDK\Exceptions;

use Exception;
use ReceptionSDK\Http\Response;

/**
 * The <code>ApiException</code> represents an API error
 */
class ApiException extends Exception
{
    /**
     * The returned error code
     * @var string $errorCode
     */
    private $errorCode;

    /**
     * Default constructor for <code>ApiException</code>
     *
     * @param string $message Exceptions message
     * @param int $code Exceptions code
     * @param mixed $previous Previous exception, if exists
     * @param string $errorCode Error code
     */
    public function __construct($message = "", $code = 0, $previous = null, $errorCode = "")
    {
        $this->setErrorCode($errorCode);
        parent::__construct($message, $code, $previous);
    }

    /**
     * String representation of the exception
     * @return string the string representation of the exception.
     */
    public function __toString()
    {
        return $this->getErrorCode() . ' - ' . parent::__toString();
    }

    /**
     * Constructs a new exception with the specified detail message.  The
     * cause is not initialized, and may subsequently be initialized by
     * a call to {@link #initCause}.
     *
     * @param mixed $json The object that has the detail message. The detail message is saved for
     *                later retrieval by the {@link #getMessage()} method.
     * @return mixed new ApiException based on json object
     */
    public static function buildFromJson($json)
    {
        $instance = new self();
        try
        {
            $instance->setErrorCode($json->code);
            if (property_exists($json, 'messages'))
            {
                $instance->message .= implode(', ', $json->messages);
            }
        } catch (Exception $e)
        {
            $instance = new self($e->getMessage(), 0, $e);
        }
        return $instance;
    }

    /**
     * Constructs a new exception based on the rest client response
     * @param Response $response
     * @return ApiException based on Response
     */
    public static function buildFromResponse(Response $response)
    {
        $instance = new self();
        try
        {
            $instance->setErrorCode($response->getBody()->code);
            if (isset($response->getBody()->messages)) {
                $instance->message .= implode(', ', $response->getBody()->messages);
            }
        } catch (Exception $e)
        {
            $instance = new self($e->getMessage(), 0, $e);
        }
        return $instance;
    }

    /**
     * Returns the exception error code
     * @return string The exception error code
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Set a new error code for the exception.
     * @param string $errorCode The new error code for the exception
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }
}
