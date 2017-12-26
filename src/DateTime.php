<?php

namespace Diskerror\Utilities;

use DateTime as DT;
use DateTimeZone;

/**
 * This class adds convienence methods to the built-in DateTime.
 *
 * Date and time can be passed in with objects or associative arrays.
 *
 * @copyright  Copyright (c) 2011 Reid Woodbury Jr.
 * @license	   http://www.apache.org/licenses/LICENSE-2.0.html	Apache License, Version 2.0
 */
class DateTime extends DT
{
    /**
	 * Default MySQL datetime format.
	 */
	const STRING_IO_FORMAT = 'Y-m-d H:i:s';

	/**
	 * Accepts a DateTime object or;
	 * Adds the ability to pass in an array or object with key names of variable
	 *	   length but a minimum of 3 characters, upper or lower case.
	 * See setTime and setDate for more information.
	 *
	 * @param object|array|string	$time -OPTIONAL
	 * @param DateTimeZone			$timezone -OPTIONAL
	 */
	public function __construct($time = 'now', $timezone = null)
	{
		if ( !is_a($timezone, 'DateTimeZone') ) {
			$timezone = new DateTimeZone(date_default_timezone_get());
		}

		switch ( gettype($time) ) {
			case 'object':
			if ( is_a($time, 'DateTime') ) {
				parent::__construct($time->format(self::STRING_IO_FORMAT), $time->getTimezone());
				break;
			}
			$time = (array) $time;
			case 'array':
			parent::__construct('now', $timezone);
			$this->setDate($time);
			$this->setTime($time);
			break;

			case 'string':
			if ( $time === '' ) {
				$time = 'now';
			}
			//	remove AD extra data
			if ( substr($time, -3) === '.0Z' ) {
				$time = substr($time, 0, 14);
			}
			parent::__construct($time, $timezone);
			break;

			case 'null':
			case 'NULL':
			parent::__construct('now', $timezone);
			break;

			default:
			throw new \InvalidArgumentException('first argument is the wrong type: ' . gettype($time));
		}
	}

	/**
	 * Create DateTime object defaults to something that will accept
	 * the default MySQL datetime format of "Y-m-d H:i:s".
	 *
	 * @param string		$formatOrTime
	 * @param string		$time -OPTIONAL
	 * @param DateTimeZone	$timezone -OPTIONAL
	 * @return DateTime
	 */
	public static function createFromFormat($formatOrTime, $time = '', $timezone = null)
	{
		if ( $time === '' ) {
			$parsed = date_parse($formatOrTime);
		} else {
			$parsed = date_parse_from_format($formatOrTime, $time);
		}

		$d = new self();

		if ( $timezone !== null ) {
			$d->setTimezone( $timezone );
		}

		$d->setDate($parsed);
		$d->setTime($parsed);

		return $d;
	}

	/**
	 * Returns MySQL formatted string.
	 * If a custom formatting is desired use DateTime::format($format).
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->format(self::STRING_IO_FORMAT);
	}

	/**
	 * Adds the ability to pass in an arrayor object with key names of variable
	 *	  length but a minimum of 3 characters, upper or lower case.
	 * Requires one object, one associative array, or 3 integer parameters.
	 *
	 * Notice: The function "getdate()" returns an array with both
	 *	  "month" and "mon" and will cause confusion here.
	 *
	 * @param object|array|int $yea
	 * @param int -DEFAULT 1
	 * @param int -DEFAULT 1
	 */
	public function setDate($yea, $mon = 1, $day = 1)
	{
		switch ( gettype($yea) ) {
			case 'object':
			$yea = (array) $yea;

			case 'array':
			//	change all keys to lower case
			$arrIn = array_change_key_case($yea);

			//	get current values as input can be incomplete
			$yea = $this->format('Y');
			$mon = $this->format('n');
			$day = $this->format('j');

			foreach ($arrIn as $k => $v) {
				switch ( substr($k, 0, 3) ) {
					case 'yea':
					$yea = $v;
					break;

					case 'mon':
					$mon = $v;
					break;

					case 'day':
					$day = $v;
					break;
				}
			}
			break;
		}

		parent::setDate((int) $yea, (int) $mon, (int) $day);

		return $this;
	}

	/**
	 * Adds the ability to pass in an array with key names of variable
	 *	  length but a minimum of 3 characters, upper or lower case.
	 * Requires one object, one associative array, or 3 integer parameters.
	 *
	 * @param object|array|int $hou
	 * @param int $min
	 * @param int $sec
	 * @param int $ms
	 */
	public function setTime($hou, $min = 0, $sec = 0, $ms = 0)
	{
		switch ( gettype($hou) ) {
			case 'object':
			$hou = (array) $hou;

			case 'array':
			//	change all keys to lower case
			$arrIn = array_change_key_case($hou);

			//	get current values as input can be incomplete
			$hou = $this->format('G');
			$min = $this->format('i');
			$sec = $this->format('s');

			foreach ($arrIn as $k => $v) {
				switch ( substr($k, 0, 3) ) {
					case 'hou':
					$hou = $v;
					break;

					case 'min':
					$min = $v;
					break;

					case 'sec':
					$sec = $v;
					break;

					case 'ms':
					$ms = $v;
					break;
				}
			}
		}

		parent::setTime((int) $hou, (int) $min, (int) $sec, (int) $ms);

		return $this;
	}
}
