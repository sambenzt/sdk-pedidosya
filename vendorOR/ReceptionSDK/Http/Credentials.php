<?php

namespace ReceptionSDK\Http;

/**
 * Service credentials for accessing API
 * @package ReceptionSDK\Http
 */
class Credentials
{
    /**
     * The client id for service access
     * You should ask PedidosYa for a client id
     * @var string
     */
    protected $clientId;

    /**
     * The client's secret access code.
     * You should ask PedidosYa for a client secret
     * @var string
     */
    protected $clientSecret;

    /**
     * The client's username.
     * You should ask PedidosYa for a username
     * @var string
     */
    protected $username;

    /**
     * The client's password.
     * You should ask PedidosYa for a password
     * @var string
     */
    protected $password;

    /**
     * The environment of the credentials
     * @var Environments
     */
    protected $environment;

    /**
     * Instantiate a new Credentials
     */
    public function __construct()
    {
        $this->environment = Environments::$DEVELOPMENT;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param mixed $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Check if using centralized keys for all the restaurants or just credentials per restaurant
     * @return bool If using centralized keys or not
     */
    public function centralizedKeys()
    {
        return is_null($this->username) || is_null($this->password);
    }
}