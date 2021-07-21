<?php

namespace ReceptionSDK\Models;

class OrderState
{
    /**
     * State of the order when is new and ready to be answered
     * @var string
     */
    public static $PENDING = 'PENDING';

    /**
     * State of the order when is confirmed
     * @var string
     */
    public static $CONFIRMED = 'CONFIRMED';

    /**
     * State of the order when is rejected
     * @var string
     */
    public static $REJECTED = 'REJECTED';

}