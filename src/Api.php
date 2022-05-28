<?php

namespace Digitnine;

require_once 'Endpoints.php';
require_once 'IdentitiyManager.php';
require_once 'Merchant.php';

use Digitnine\Endpoints;
use Digitnine\IdentityManager;
use Digitnine\Merchant;

/**
 * Class Api
 * Api for Digit9 Operations
 *
 * @package Digitnine
 */
class Api
{

	protected static $key = 'test-key';
	protected static $secret = 'test-secret';
	protected static $isProduction = false;
	protected static $epObj ;

	/*
     * App info is to store the Plugin/integration
     * information
     */
	public static $appsDetails = array();

	const VERSION = '1.0.0';

	/**
	 * @param string $key
	 * @param string $secret
	 */
	public function __construct($key, $secret, $isProduction = false)
	{
		self::$key = $key;
		self::$secret = $secret;
		self::$isProduction = $isProduction;
		self::$epObj = Endpoints::getInstance();
		self::$epObj->setProdFlag(false) ;

	}


	public static function getKey()
	{
		return self::$key;
	}

	public static function getSecret()
	{
		return self::$secret;
	}

	public static function checkProduction()
	{
		return self::$isProduction;
	}

	public static function getToken()
	{
		$data['username'] = self::$key;
		$data['password'] = self::$secret; 

		$idm = new IdentityManager();

		return  $idm->getToken($data);
	}
}
