<?php

namespace ReceptionSDK\Exceptions;
use Exception;

class ConnectionException extends Exception
{

    /**
     * Instatiate a new ConnectionException
     *
     * @param string $message Exceptions message
     * @param int $code Exceptions code
     * @param mixed $previous Previous exception, if exists
     *
     */
    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}