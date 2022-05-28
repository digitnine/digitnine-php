<?php

namespace Digitnine;

use GuzzleHttp\Client;

/**
 * Class Merchant
 *
 * @package Digitnine\Merchant
 */
class Merchant
{

    private static $serviceURL;

    public function __construct()
    {
        $epObj = Endpoints::getInstance();
        self::$serviceURL = $epObj->getMerchantServiceUrl();
    }

    /**
     * @param $url
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function getToken($data)
    {
        $client = new Client();

        $url = self::$serviceURL . "/oauth/token";

        $options = [
            //'form_params' => ['data' => json_encode($data)], 
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode("merchantPortal:password"),
            ], 'query' => [

                "grant_type" => "password",
                "username" => $data['username'],
                "password" => $data['password']

            ]
        ];

        // if (Api::$proxy != '') {
        //     $options['proxy'] = Api::$proxy;
        // }

        //print_r($options);

        try {
            $response = $client->post($url, $options);
            $reason = $response->getReasonPhrase(); // OK

            if ($reason == "OK") {
                return $response->getBody();
            } else {
            }
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
}
