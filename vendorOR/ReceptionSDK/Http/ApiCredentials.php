<?php

namespace ReceptionSDK\Http;

/**
 * Class ApiCredentials
 * Internal service credentials for accessing API
 * @package ReceptionSDK\Http
 */
class ApiCredentials extends Credentials
{
    /**
     * Push method access key
     * @var string
     */
    private $orderAccessKey = '';

    /**
     * Push method secret key
     * @var string
     */
    private $orderSecretKey = '';

    /**
     * Push method environment
     * @var string
     */
    private $regionEndpoint = '';

    /**
     * Push method orders queue
     * @var string
     */
    private $queueName = '';

    /**
     * Instantiate a new ApiCredentials
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->clientId = $credentials->clientId;
        $this->clientSecret = $credentials->clientSecret;
        $this->username = $credentials->username;
        $this->password = $credentials->password;
        $this->environment = $credentials->environment;
    }

    /**
     * @param string $orderAccessKey
     */
    public function setOrderAccessKey($orderAccessKey)
    {
        $this->orderAccessKey = $orderAccessKey;
    }

    /**
     * @param string $orderSecretKey
     */
    public function setOrderSecretKey($orderSecretKey)
    {
        $this->orderSecretKey = $orderSecretKey;
    }

    /**
     * @param string $regionEndpoint
     */
    public function setRegionEndpoint($regionEndpoint)
    {
        $this->regionEndpoint = $regionEndpoint;
    }

    /**
     * @param string $queueName
     */
    public function setQueueName($queueName)
    {
        $this->queueName = $queueName;
    }

    /**
     * Check if the credentials are allowed to use the push receiving method
     * @return bool
     */
    public function pushAvailable()
    {
        return !(empty($this->orderAccessKey) ||
            empty($this->orderSecretKey) ||
            empty($this->regionEndpoint) ||
            empty($this->queueName)
        );
    }


}