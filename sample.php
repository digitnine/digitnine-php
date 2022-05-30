<?php

require_once './vendor/autoload.php';
require_once './src/Api.php';


use Digitnine\Api;

$api_key = "sp2";
$api_secret = "password";
$is_production = false;

$api = new Api($api_key, $api_secret,$is_production );


//print_r( $api->getKey() );


print_r($api->checkProduction());
echo "Manga";

print_r($api->getToken());
