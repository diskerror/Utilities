<?php

namespace Diskerror\Utilities;

/**
 * Provides an array with LIFO (last in first out) behavior.
 *
 * The focus of this class is the destructor which removes items in the reverse
 *   order that items were added. Other methods are here for completeness.
 *
 * Key-values pairs can be accessed with either array or object notation.
 *
 * @copyright  Copyright (c) 2008 Reid Woodbury Jr.
 * @license	   http://www.apache.org/licenses/LICENSE-2.0.html	Apache License, Version 2.0
 */
class Stack implements \ArrayAccess, \Countable
{
	/**#@+
	* @access protected
	*/

	/**
	 * Array of items to store.
	 * @type array
	 */
	protected $_stack;

	/**
	 * Constructor.
	 */
	public final function __construct()
	{
		$this->_stack = [];
	}

	/**
	 * Destructor.
	 * Items are "unset" in the reverse order in which they were set.
	 */
	public final function __destruct()
	{
		for ( $c = count($this->_stack); $c; --$c ) {
			array_pop($this->_stack);
		}
	}

	/**
	 * Retrieve value from the named location with class notation.
	 * If not set then return null.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public final function __get($key)
	{
		if ( array_key_exists($key, $this->_stack) ) {
			return $this->_stack[$key];
		}

		return null;
	}

	/**
	 * Retrieve value from the named location with array notation.
	 * Accessing a key that does not exist will cause an error.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public final function offsetGet($key)
	{
		return $this->_stack[$key];
	}

	/**
	 * Sets a value to the named location with class notation.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @throws DomainException
	 */
	public final function __set($key, $value)
	{
		$key = (string) $key;

		if ( array_key_exists($key, $this->_stack) ) {
			throw new \DomainException('Key already exists.');
		}

		$this->_stack[$key] = $value;
	}

	/**
	 * Sets a value to the new named location with array notation.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @throws DomainException
	 */
	public final function offsetSet($key, $value)
	{
		$key = (string) $key;

		if ( array_key_exists($key, $this->_stack) ) {
			throw new \DomainException('Key already exists.');
		}

		$this->_stack[$key] = $value;
	}

	/**
	 * Checks if the the named location exists.
	 *
	 * @param string $key
	 * @return bool
	 */
	public final function __isset($key)
	{
		return ( array_key_exists($key, $this->_stack) && isset($this->_stack[$key]) );
	}

	/**
	 * Checks if the the named location exists.
	 *
	 * @param string $key
	 * @return bool
	 */
	public final function offsetExists($key)
	{
		return ( array_key_exists($key, $this->_stack) && isset($this->_stack[$key]) );
	}

	/**
	 * @param string $key
	 * @throws DomainException
	 */
	public final function __unset($key)
	{
		throw new \DomainException('Cannot unset a member.');
	}

	/**
	 * @param string $key
	 * @throws DomainException
	 */
	public final function offsetUnset($key)
	{
		throw new \DomainException('Cannot unset a member.');
	}

	/**
	 * Returns the number of elements in the stack.
	 *
	 * @return integer
	 */
	public final function count()
	{
		return count($this->_stack);
	}

	/**
	 * Remove and return last member value.
	 *
	 * @return mixed
	 */
	public final function pop()
	{
		if ( count($this->_stack) ) {
			return array_pop($this->_stack);
		}

		return null;
	}
}
