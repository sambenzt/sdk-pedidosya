<?php

namespace ReceptionSDK\Helpers;

class SessionHelper
{
    /**
     * @var string Prefix to use for session variables.
     */
    private $sessionPrefix = 'PEDIDOSYA_';

    /**
     * @var string Session id for SDK.
     */
    private $sessionId = 'pedidosya';

    /**
     * Init the session helper.
     *
     */
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_id();
            //session_id($this->sessionId);
            //session_start();
        }
    }

    /**
     * Get a value from session
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if (isset($_SESSION[$this->sessionPrefix . $key])) {
            return $_SESSION[$this->sessionPrefix . $key];
        }

        return null;
    }

    /**
     * Set a value in session
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $_SESSION[$this->sessionPrefix . $key] = $value;
    }
}
