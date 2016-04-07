<?php

namespace Diskerror\Utilities;

/**
 * Provides a registry with LIFO (last in first out) behavior.
 *
 * This adds singleton behavior to \Diskerror\Utilities\Stack to mimic some of
 *   the behavior of Zend_Registry.
 *
 * Key-values pairs can be accessed with either array or object notation.
 *
 * @copyright  Copyright (c) 2008 Reid Woodbury Jr.
 * @license	   http://www.apache.org/licenses/LICENSE-2.0.html	Apache License, Version 2.0
 */
class Registry extends Stack
{
	/**#@+
	 * @access protected
	 */

	/**
	 * Singleton instance of this class.
	 * @type Diskerror\Utilities\Registry
	 * @static
	 */
	private static $_instance;

	/**
	 * Create static instance if it doesn't exist.
	 */
	private static final function _checkInstance()
	{
		if ( !isset(self::$_instance) ) {
			self::$_instance = new self;
		}
	}

	/**
	 * Retrieves the static instance when for use as a singleton.
	 *
	 * @return Diskerror\Utilities\Registry
	 */
	public final static function getInstance()
	{
		self::_checkInstance();
		return self::$_instance;
	}

	/**
	 * Unset the default stack instance.
	 * Primarily used in tearDown() in unit tests.
	 * @returns void
	 */
	public final static function unsetInstance()
	{
		if ( isset(self::$_instance) ) {
			self::$_instance = null;	//	can't unset a static property
		}
	}

	/**
	 * Gets data from singleton instance.
	 *
	 * @param string|int $key
	 * @return mixed
	 */
	public final static function get($key)
	{
		self::_checkInstance();
		return self::$_instance->offsetGet($key);
	}

	/**
	 * Sets data to singleton instance.
	 *
	 * @param string|int $key
	 * @param mixed $value.
	 */
	public final static function set($key, $value)
	{
		self::_checkInstance();
		self::$_instance->offsetSet($key, $value);
	}

}
