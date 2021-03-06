<?php

namespace Phile;

/**
 * the Service Locator class
 * @author Frank Nägler
 *
 */
class ServiceLocator {
	/**
	 * @var array of services
	 */
	protected static $services;

	protected static $serviceMap = array(
		'Phile_Cache'               => 'Phile\Cache\CacheInterface',
		'Phile_Template'            => 'Phile\Template\TemplateInterface',
		'Phile_Parser'              => 'Phile\Parser\ParserInterface',
		'Phile_Data_Persistence'    => 'Phile\Persistence\PersistenceInterface'
	);

	/**
	 * @param string $serviceKey the key for the service
	 * @param mixed $object
	 */
	public static function registerService($serviceKey, $object) {
		$interfaces = class_implements($object);
		$interface = self::$serviceMap[$serviceKey];
		if ($interfaces === FALSE || !in_array($interface, $interfaces)) {
			throw new Exception("the object must implement the interface: '{$interface}'");
		}
		self::$services[$serviceKey] = $object;
	}

	/**
	 * checks if a service is registered
	 * @param string $serviceKey
	 * @return bool
	 */
	public static function hasService($serviceKey) {
		return (isset(self::$services[$serviceKey]));
	}

	/**
	 * returns a service
	 *
	 * @param string $serviceKey the service key
	 * @return mixed
	 * @throws Exception
	 */
	public static function getService($serviceKey) {
		if (!isset(self::$services[$serviceKey])) {
			throw new Exception("the service '{$serviceKey}' is not registered");
		}
		return self::$services[$serviceKey];
	}
}
