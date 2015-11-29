<?php

namespace Diskerror\Utilities;

use ArrayAccess, OutOfBoundsException;

/**
 * Provides a registry with LIFO (last in first out) behavior.
 *
 * The focus of this class is optional singleton usage, setting
 *	 of members, and the destructor which removes items in the
 *	 reverse order that items were added. Other methods are here
 *	 for completeness.
 *
 * Key-values pairs can be accessed with either array or object notation.
 *
 * @copyright  Copyright (c) 2008 Reid Woodbury Jr.
 * @license	   http://www.apache.org/licenses/LICENSE-2.0.html	Apache License, Version 2.0
 */
class Registry implements ArrayAccess
{
	/**#@+
	* @access protected
	*/

	/**
	 * Singleton instance of this class.
	 * @var Diskerror\Utilities\Registry
	 * @static
	 */
	private static $_instance;

	/**
	 * Array of items to store.
	 * @var array
	 */
	protected $_registry = [];

	/**
	 * Public constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * Public destructor.
	 */
	public function __destruct()
	{
		//	items are "unset" in the reverse order in which they were first set
		while ( count($this->_registry) ) {
			array_pop($this->_registry);
		}
	}

	/**
	 * Retrieves the static instance when for use as a singleton.
	 *
	 * @return Diskerror\Utilities\Registry
	 */
	public static function getInstance()
	{
		if ( !isset(self::$_instance) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Gets data from singleton instance.
	 *
	 * @param string|int $key
	 * @return mixed
	 * @throws OutOfBoundsException
	 */
	public static function get($key)
	{
		return self::getInstance()->offsetGet($key);
	}

	/**
	 * Sets data to singleton instance.
	 *
	 * @param string|int $key
	 * @param mixed $value.
	 * @return void
	 */
	public static function set($key, $value)
	{
		self::getInstance()->offsetSet($key, $value);
	}

	/**
	 * Sets a value to the named location.
	 * Calls with keys that are not non-zero-length strings are pushed onto The Stack
	 *	  without a named reference.
	 *
	 * @param string|int $key
	 * @param mixed $value
	 */
	public function __set($key, $value)
	{
		$key = (string) $key;

		if ( array_key_exists($key, $this->_registry) ) {
			throw new Exception("Key already exists.");
		}

		$this->_registry[$key] = $value;
	}

	/**
	 * Sets a value to the named location.
	 *
	 * @param string|int $key
	 * @param mixed $value
	 */
	public function offsetSet($key, $value)
	{
		$key = (string) $key;

		if ( array_key_exists($key, $this->_registry) ) {
			throw new Exception("Key already exists.");
		}

		$this->_registry[$key] = $value;
	}

	/**
	 * Retrieve value from the named location. If not set then return null.
	 *
	 * @param string|int $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->_registry[$key];
	}

	/**
	 * Retrieve value from the named location.
	 *
	 * @param string|int $key
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->_registry[$key];
	}

	/**
	 * Checks if the the named location exists.
	 *
	 * @param string|int $key
	 * @return bool
	 */
	public function __isset($key)
	{
		return ( array_key_exists($key, $this->_registry) && isset($this->_registry[$key]) );
	}

	/**
	 * Checks if the the named location exists.
	 *
	 * @param string|int $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return ( array_key_exists($key, $this->_registry) && isset($this->_registry[$key]) );
	}

	/**
	 * Unsets or clears the named location if it exists.
	 *
	 * @param string|int $key
	 */
	public function __unset($key)
	{
		throw new Exception("Cannot unset a member.");
	}

	/**
	 * Unsets or clears the named location if it exists.
	 *
	 * @param string|int $key
	 */
	public function offsetUnset($key)
	{
		throw new Exception("Cannot unset a member.");
	}

}
