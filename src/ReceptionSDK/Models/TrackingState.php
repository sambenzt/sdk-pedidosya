<?php

namespace ReceptionSDK\Models;

class TrackingState
{
    /**
     * State of the tracking when it failed
     * @var string
     */
    public static $FAILURE = "FAILURE";

    /**
     * State of the tracking when a driver is being requested
     * @var string
     */
    public static $REQUESTING_DRIVER = "REQUESTING_DRIVER";

    /**
     * State of the tracking when the order is being transmitted
     * @var string
     */
    public static $TRANSMITTING = "TRANSMITTING";

    /**
     * State of the tracking when the order is finally transmitted
     * @var string
     */
    public static $TRANSMITTED = "TRANSMITTED";

    /**
     * State of the tracking when the order is being prepared
     * @var string
     */
    public static $PREPARING = "PREPARING";

    /**
     * State of the tracking when the order is being delivered
     * @var string
     */
    public static $DELIVERING = "DELIVERING";

    /**
     * State of the tracking when the order is finally delivered
     * @var string
     */
    public static $DELIVERED = "DELIVERED";

    /**
     * State of the tracking when the order is closed and no live tracking happens
     * @var string
     */
    public static $CLOSED = "CLOSED";

}
