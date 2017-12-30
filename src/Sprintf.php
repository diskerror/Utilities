<?php

namespace Diskerror\Utilities;

/**
 * Extends sprintf with options suitable for generating MySQL query strings.
 *
 * @copyright  Copyright (c) 2011 Reid Woodbury Jr
 * @license	   http://www.apache.org/licenses/LICENSE-2.0.html	Apache License, Version 2.0
 */
class Sprintf
{
	const SPEC_FIND = '/(%(?:\d+\$)?(?:\'.|[^aAbcdeEfFgGHoqQsStTuxX])?[\d.]*)';
	const FILTERS = '/%(?:\d+\$)?(?:\'.|[^aAbcdeEfFgGHoqQsStTuxX])?[\d.]*([aAbcdeEfFgGHoqQsStTuxX])/u';
	const ESCAPE_REG = '/([\x00-\x1F\x22\x27\x5C\x7F])/u';	//	Covers the ASCII charset.

	/**
	 * Prepped sprintf format string.
	 *
	 * @var string
	 */
	protected $_formatStr;

	/**
	 * Array of specifications to escape.
	 *
	 * @var array
	 */
	protected $_specsToEsc;

	/**
	 * Array of specifications to change to hexidecimal code.
	 *
	 * @var array
	 */
	protected $_specsToHex;

	/**
	 * Constructor.
	 *
	 * @param string $formatStr
	 * @param bool $removeLeadSpace -OPTIONAL
	 */
	public function __construct($formatStr, $removeLeadSpace = true)
	{
		$this->init($formatStr, $removeLeadSpace);
	}

	/**
	 * Set format specification string. Can be chained.
	 *
	 * Reference numbers (the "4$" inside "%4$s") here and in sprintf are 1-based.
	 * Note that this is changed and stored interally as a 0-based indexed array.
	 *
	 * **These should NOT be used as they cannot be handled well without replacing
	 *	 the PHP builtin printf variant used for formatting.**
	 *
	 * @param string $formatStr
	 * @param bool $removeLeadSpace -OPTIONAL
	 * @return Diskerror\Utilities\Sprintf
	 */
	public function init($formatStr, $removeLeadSpace = true)
	{
		//	Convert new spec types to proper format string with proper added charactera.
		$this->_formatStr = preg_replace(
			array(
				self::SPEC_FIND . '[aA]/u',
				self::SPEC_FIND . 'H/u',
				self::SPEC_FIND . '[qQ]/u',
				self::SPEC_FIND . 'S/u',
				self::SPEC_FIND . '[tT]/u'
			),
			array(
				'\'$1s\'',
				'$1s',
				'"$1s"',
				'$1s',
				'`$1s`'
			),
			$formatStr
		);

		//	removes initial tabs or spaces from line
		if ( $removeLeadSpace ) {
			$this->_formatStr = preg_replace('/^\s+/um', '', $this->_formatStr);
		}

		//	create an array of specification letters
		$specs = array();
		$specCount = preg_match_all(self::FILTERS, $formatStr, $specs);

		//	remove escaping pointer to numbered specifiers
		//	we're assuming they're used from some place earlier
		$numSpec = array();
		for ( $l = $specCount - 1; $l >= 0; --$l ) {
			if ( false !== strpos($specs[0][$l], '$') ) {
				$numSpec[] = $specs[0][$l];
				unset($specs[0][$l], $specs[1][$l]);
				--$specCount;
			}
		}
		$specs[0] = array_values($specs[0]);
		$specs[1] = array_values($specs[1]);

		//	Save the indexes of the specs to escape.
		//	Members might not be at sequential indexes.
		$this->_specsToEsc = array();
		$this->_specsToHex = array();
		for ($i = 0; $i < $specCount; ++$i) {
			switch ( $specs[1][$i] ) {
				case 'A':
				case 'Q':
				case 'S':
				case 'T':
				$this->_specsToEsc[] = $i;
				break;

				case 'H':
				$this->_specsToHex[] = $i;
				break;
			}
		}

		//	Add values from referenced specs.
		foreach ($numSpec as $ns) {
			if ( preg_match('/A|Q|S|T/u', $ns) ) {
				$ref = preg_replace('/^\D*(\d+)\D*$/u', '$1', $ns) - 1;
				if ( !in_array($ref, $this->_specsToEsc) ) {
					$this->_specsToEsc[] = $ref;
				}
				if ( !in_array($ref, $this->_specsToHex) ) {
					$this->_specsToHex[] = $ref;
				}
			}
		}

		return $this;	//	allows for chaining
	}

	/**
	 * Bind input values to the stored format string by position.
	 * May have an array or any number of scalar arguments.
	 *
	 * @param mixed $aIn
	 * @return string
	 */
	public function bind($aIn)
	{
		$aIn = ( is_array($aIn) ? array_values($aIn) : func_get_args() );

		foreach ( $this->_specsToEsc as $s ) {
			//			$aIn[$s] = addslashes($aIn[$s]);
			$aIn[$s] = preg_replace(self::ESCAPE_REG, '\\\\$1', $aIn[$s]);
		}

		foreach ( $this->_specsToHex as $s ) {
			$aIn[$s] = ( $aIn[$s] === '' ? '""' : '0x' . bin2hex($aIn[$s]) );
		}

		return vsprintf( $this->_formatStr, $aIn );
	}

	/**
	 * Bind input values to the stored format string by position.
	 * May have an array or any number of scalar arguments.
	 *
	 * @param mixed $aIn
	 * @return string
	 */
	public function __invoke($aIn)
	{
		return	is_array($aIn) ? $this->bind($aIn) : $this->bind(func_get_args());
	}
}
