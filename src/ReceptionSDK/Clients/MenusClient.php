<?php

namespace ReceptionSDK\Clients;

use ReceptionSDK\Helpers\Ensure;
use ReceptionSDK\Http\ApiConnection;

/**
 * Class MenusClient
 * @package ReceptionSDK\Clients
 */
class MenusClient
{
    /**
     * @var ApiConnection
     */
    private $connection;

    /**
     * @var SectionsClient
     */
    private $section;

    /**
     * @var OptionsClient
     */
    private $option;

    /**
     * @var OptionGroupClient
     */
    private $optionGroup;

    /**
     * @var ProductsClient
     */
    private $product;

    /**
     * MenusClient constructor.
     * Instantiate a new Menus API client.
     * @param ApiConnection $connection
     */
    public function __construct($connection)
    {
        Ensure::argumentNotNull($connection, 'connection');

        $this->connection = $connection;
        $this->section = new SectionsClient($this->connection);
        $this->option = new OptionsClient($this->connection);
        $this->optionGroup = new OptionGroupClient($this->connection);
        $this->product = new ProductsClient($this->connection);
    }

    /**
     * Client for the Sections API
     * @return SectionsClient
     */
    public function section()
    {
        return $this->section;
    }

    /**
     * Client for the Options API
     * @return OptionsClient
     */
    public function option()
    {
        return $this->option;
    }

    /**
     * Client for the OptionGroup API
     * @return OptionGroupClient
     */
    public function optionGroup()
    {
        return $this->optionGroup;
    }

    /**
     * Client for the Product API.
     * @return ProductsClient
     */
    public function product()
    {
        return $this->product;
    }

}
