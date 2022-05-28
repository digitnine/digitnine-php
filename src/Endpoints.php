<?php

namespace Digitnine;

/**
 * Class Endpoints
 *
 * @package Digitnine\Endpoints
 */
class Endpoints
{
    public static $isProduction = false;

    //staging  
    const sandboxURLs = array(
        'merchant' => 'http://merchant-service-dev.digitnine.com',
        'idm' => 'http://idm-service-dev.digitnine.com'
    );

    //production 
    const productionURLs = array(
        'merchant' => 'http://merchant-service.digitnine.com',
        'idm' => 'http://idm-service.digitnine.com'
    );

    private static $instances = [];

    /**
     * The Singleton's constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    protected function __construct()
    {
    }
    public function setProdFlag($prodFlag = false)
    {
        self::$isProduction = $prodFlag;
    }

    /**
     * Singletons should not be cloneable.
     */
    protected function __clone()
    {
    }

    /**
     * Singletons should not be restorable from strings.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
    public static function getInstance(): Endpoints
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }


    public static function getIDMServiceUrl()
    {
        return self::$isProduction ?
            self::productionURLs['idm'] : self::sandboxURLs['idm'];
    }

    public static function getMerchantServiceUrl()
    {
        return self::$isProduction ?
            self::productionURLs['merchant'] : self::sandboxURLs['merchant'];
    }
}
