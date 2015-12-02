<?php

namespace Diskerror\Utilities;

/**
 * Abstract class for getting the instance of a called class.
 * Uses Registry for external storage enabling a heritable class.
 *
 * @copyright  Copyright (c) 2011 Reid Woodbury Jr.
 * @license	   http://www.apache.org/licenses/LICENSE-2.0.html	Apache License, Version 2.0
 */
abstract class Singleton
{
	/**
	 * Protected constructor.
	 * Override to perform any initialization.
	 */
	protected function __construct()
	{
	}

	/**
	 * Making method private prevents any copy being made of the class.
	 */
	private function __clone()
	{
	}

	/**
	 * Returns the instance of the called class.
	 *
	 * @return	Diskerror\Utilities\Singleton
	 */
	public static function getInstance()
	{
		$calledClass = get_called_class();
		$registry = Registry::getInstance();

		return (
			isset($registry[$calledClass]) ?
				$registry[$calledClass] :
				($registry[$calledClass] = new $calledClass())
		);
	}
}
