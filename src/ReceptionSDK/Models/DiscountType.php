<?php

namespace ReceptionSDK\Models;

class DiscountType
{
    /**
     * Type of discount when it's specified by percentage value
     * @var string
     */
    public static $PERCENTAGE = 'PERCENTAGE';

    /**
     * Type of discount when it's specified by an amount of money
     * @var string
     */
    public static $VALUE = 'VALUE';

}