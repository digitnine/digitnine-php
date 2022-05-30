<?php

namespace Digitnine\Api;

use GuzzleHttp\Client;

/**
 * Class IdentityManager
 *
 * @package Digitnine\Api
 */
class IdentityManager
{

    private static $serviceURL;
    private static $gzClient;
    private static $authToken;

    public function __construct($token = null)
    {
        $epObj = Endpoints::getInstance();
        self::$serviceURL = $epObj->getIDMServiceUrl();
        self::$gzClient = new Client(['base_uri' => self::$serviceURL]);
        self::$authToken = $token;
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

        $uri = "/oauth/token";

        try {
            $response = self::$gzClient->post($uri, $options);
            $reason = $response->getReasonPhrase(); // OK

            if ($reason == "OK") {
                $access_token = json_decode($response->getBody()->getContents(), true)['access_token'];
                //print_r($access_token) ; 
                return $access_token;
            } else {
            }
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }

    public static function getCurrentUserDetails()
    {
        $options = [ 
            'headers' => [
                'Authorization' => 'Bearer ' . self::$authToken,
            ]
        ]; 

        // print_r($options);
        // exit ;

        $uri = "/users/me";

        try {
            $response = self::$gzClient->get($uri, $options);
            $reason = $response->getReasonPhrase(); // OK

            if ($reason == "OK") {
                $current_user = json_decode($response->getBody()->getContents() , true);
                return $current_user;
            } else {
            }
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
}
