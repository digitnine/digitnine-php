<?php

namespace Digitnine\Api;

session_start();
require_once 'Endpoints.php';
require_once 'IdentitiyManager.php';
require_once 'Merchant.php';

use Digitnine\Api\Endpoints;
use Digitnine\Api\IdentityManager;
use Digitnine\Api\Merchant;

/**
 * Class Api
 * Api for Digit9 Operations
 *
 * @package Digitnine\Api
 */
class Api
{

	protected static $key = 'test-key';
	protected static $secret = 'test-secret';
	protected static $token;
	protected static $cacheToken = false;
	protected static $isProduction = false;
	protected static $epObj;

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
		self::$epObj->setProdFlag(false);
		self::$token = self::getToken();
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

	private static function getToken()
	{
		$data['username'] = self::$key;
		$data['password'] = self::$secret;

		if (self::$cacheToken) {
			//unset($_SESSION['token']) ;

			if (!empty($_SESSION['token'])) {
				//echo "cached token \n";
				return $_SESSION['token'];
			} else {

				$idm = new IdentityManager();
				$token_data = $idm->getToken($data);;
				if ($token_data) {
					$_SESSION['token'] = $token_data;
					//echo "fetched token \n";
					return $_SESSION['token'];
				} else {
					return  false;
				}
			}
		} else {
			if (!empty(self::$token)) {
				return self::$token;
			} else {
				$idm = new IdentityManager();
				$token_data = $idm->getToken($data);
				if ($token_data) {
					return $token_data;
				} else {
					return  false;
				}
			}
		}
	}

	public static function getCurrentUserDetails()
	{
		$idm = new IdentityManager(self::$token);
		return $idm->getCurrentUserDetails();
	}

	public static function getWallets($pagination_data = null)
	{
		$merchant = new Merchant(self::$token);
		return $merchant->getWallets($pagination_data);
	}
}
