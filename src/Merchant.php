<?php

namespace Digitnine\Api;

use GuzzleHttp\Client;

/**
 * Class Merchant
 *
 * @package Digitnine\Api
 */
class Merchant
{

    private static $serviceURL;
    private static $gzClient;
    private static $authToken;

    public function __construct($token = null)
    {
        $epObj = Endpoints::getInstance();
        self::$serviceURL = $epObj->getMerchantServiceUrl();
        self::$gzClient = new Client(['base_uri' => self::$serviceURL]);
        self::$authToken = $token;
    }

    /**
     * @param $url
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function getWallets($data)
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . self::$authToken,
            ], 'query' => [
                "size" => $data['size'] ?? 10,
                "page" => $data['page'] ?? 0
            ]
        ];


        // print_r($options);
        // exit ;

        $uri = "/v1/service-provider/wallets";

        try {
            $response = self::$gzClient->get($uri, $options);
            $reason = $response->getReasonPhrase(); // OK

            if ($reason == "OK") {
                $wallets = json_decode($response->getBody()->getContents(), true)['content'];
                return $wallets;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
}
