<?php

//require_once './py-reception-sdk.phar';
require_once '../vendor/autoload.php';

use ReceptionSDK\Http\Credentials;
use ReceptionSDK\Http\Environments;
use ReceptionSDK\ApiClient;
use ReceptionSDK\Exceptions\ApiException;

//clientId: integration_maxirest
//clientSecret: r28m4s5c1z

$credentials = new Credentials();
$credentials->setClientId('integration_maxirest');
$credentials->setClientSecret('r28m4s5c1z');
$credentials->setEnvironment(Environments::$DEVELOPMENT);

try{
    $api = new ApiClient($Credentials);
    //$deliveryTimes=$api->order()->deliveryTime()->getAll();
}
catch(ApiException $e){
    print_r($e);
}

