<?php

namespace ReceptionSDK\Exceptions;

/**
 * Possible API error codes
 */
class ErrorCode
{
    /**
     * You should not see this code but be prepared
     */
    public static $INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';

    /**
     * When trying to update an order that has been cancelled already
     */
    public static $ORDER_CANCELLED = 'ORDER_CANCELLED';

    /**
     * When trying to update an order that has been confirmed already
     */
    public static $ORDER_CONFIRMED = 'ORDER_CONFIRMED';

    /**
     * When trying to update an order that has been rejected already
     */
    public static $ORDER_REJECTED = 'ORDER_REJECTED';

    /**
     * When the token is invalid or you don't have permission
     */
    public static $INVALID_TOKEN = 'INVALID_TOKEN';

    /**
     * When the resource not exists
     */
    public static $NOT_EXISTS = 'NOT_EXISTS';

    /**
     * When some parameter is missing in the request
     */
    public static $MISSING_PARAM = 'MISSING_PARAM';

    /**
     * When a product with the same integration code already exists
     */
    public static $MENU_ITEM_ALREADY_EXISTS = 'MENU_ITEM_ALREADY_EXISTS';

    /**
     * When trying to create a new product with a new vertical partner
     */
    public static $NOT_ALLOWED = "NOT_ALLOWED";

    /**
     * When the product is being validated by Pedidos Ya
     */
    public static $PRODUCT_VALIDATE_PROCESSING = "PRODUCT_VALIDATE_PROCESSING";

    /**
     * When the product cannot be sold in Pedidos Ya
     */
    public static $PRODUCT_NOT_AVAILABLE_FOR_SALE = "PRODUCT_NOT_AVAILABLE_FOR_SALE";

    /**
     * When a request to validate the product was created by Pedidos Ya
     */
    public static $PRODUCT_CREATION_REQUEST_CREATED = "PRODUCT_CREATION_REQUEST_CREATED";

    /**
     * When the partner does not use catalog
     */
    public static $PARTNER_NOT_USE_CATALOGUE = "PARTNER_NOT_USE_CATALOGUE";

    /**
     * When some parameter is invalid in the request
     */
    public static $INVALID_PARAMS = "INVALID_PARAMS";

    /**
     * When the partner does match with reception system
     */
    public static $NOT_AUHTORIZED = "NOT_AUHTORIZED";
}
