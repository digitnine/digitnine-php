<?php

require_once   __DIR__ . '/vendor/autoload.php';
require_once __DIR__ .'/src/Api.php';


use Digitnine\Api;

$api_key = "sp2";
$api_secret = "password";
$is_production = false;

$api = new Api($api_key, $api_secret,$is_production );

echo "<pre>" ;

echo "User Details \n" ; 

print_r($api->getCurrentUserDetails());

echo "User Wallet \n" ; 

print_r($api->getWallets());



echo "</pre>" ;