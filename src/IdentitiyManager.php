<?php

namespace Digitnine;

use GuzzleHttp\Client;

/**
 * Class IdentityManager
 *
 * @package Digitnine\IdentityManager
 */
class IdentityManager
{

    private static $serviceURL;
    private static $gzClient;

    public function __construct()
    {
        $epObj = Endpoints::getInstance();
        self::$serviceURL = $epObj->getIDMServiceUrl();
        self::$gzClient = new Client(['base_uri' => self::$serviceURL ]);

    }

    /**
     * @param $url
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function getToken($data)
    {
         

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

        $uri ="/oauth/token";

        try {
            $response = self::$gzClient->post($uri, $options);
            $reason = $response->getReasonPhrase(); // OK

            if ($reason == "OK") {
                $access_token = json_decode ($response->getBody()->read(1024), true )['access_token'];
                return $access_token  ;
            } else {
            }
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
}
