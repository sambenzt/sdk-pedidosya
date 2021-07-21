<?php

namespace ReceptionSDK;

use ReceptionSDK\Clients\EventsClient;
use ReceptionSDK\Clients\MenusClient;
use ReceptionSDK\Clients\OptionGroupClient;
use ReceptionSDK\Clients\OptionsClient;
use ReceptionSDK\Clients\OrdersClient;
use ReceptionSDK\Clients\ProductsClient;
use ReceptionSDK\Clients\RestaurantsClient;
use ReceptionSDK\Clients\CataloguesClient;
use ReceptionSDK\Clients\SectionsClient;
use ReceptionSDK\Http\ApiConnection;
use ReceptionSDK\Http\Credentials;

require(dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php');
echo (dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php');
/**
 * A client for the PedidosYa API
 */
class ApiClient
{
    /**
     * @var ApiConnection
     */
    private $connection;

    /**
     * @var OrdersClient
     */
    private $order;

    /**
     * @var MenusClient
     */
    private $menu;

    /**
     * @var EventsClient
     */
    private $event;

    /**
     * @var RestaurantsClient
     */
    private $restaurant;



    /**
     * Instantiate a new API client.
     * ApiClient constructor.
     * @param Credentials $credentials
     */
    public function __construct($credentials)
    {
        $this->connection = new ApiConnection($credentials);
        $this->order = new OrdersClient($this->connection);
        $this->menu = new MenusClient($this->connection);
        $this->event = new EventsClient($this->connection);
        $this->restaurant = new RestaurantsClient($this->connection);
    }

    /**
     * Client for the Orders API.
     * @return OrdersClient
     */
    public function order()
    {
        return $this->order;
    }

    /**
     * Client for the Menus API.
     * @return MenusClient
     */
    public function menu()
    {
        return $this->menu;
    }

    /**
     * Client for the Events API.
     * @return EventsClient
     */
    public function event()
    {
        return $this->event;
    }

    /**
     * Client for the Restaurants API.
     * @return RestaurantsClient
     */
    public function restaurant()
    {
        return $this->restaurant;
    }


    /**
     * Provides a client connection to make rest requests to HTTP endpoints.
     * @return ApiConnection
     */
    public function connection()
    {
        return $this->connection;
    }
}
