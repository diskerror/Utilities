<?php
class StackTest extends PHPUnit\Framework\TestCase
{
	public function testArray()
	{
		$stack = new Diskerror\Utilities\Stack;
		for ( $i = 0; $i < 100; ++$i ) {
			$stack[$i] = $i * M_PI;
		}

		$this->assertTrue( isset($stack[95]) );
		$this->assertFalse( isset($stack[105]) );

		$this->assertEquals(100, count($stack));
		$this->assertEquals(99*M_PI, $stack[99]);
	}

	/**
	 * @depends						testArray
	 * @expectedException			DomainException
	 * @expectedExceptionMessage	Cannot unset a member.
	 */
	public function testArrayUnset()
	{
		$stack = new Diskerror\Utilities\Stack;
		for ( $i = 0; $i < 6; ++$i ) {
			$stack[$i] = $i * M_PI;
		}

		unset($stack[4]);
	}

	/**
	 * @depends				testArray
	 */
	public function testArrayExistance()
	{
		$stack = new Diskerror\Utilities\Stack;
		for ( $i = 5; $i < 8; ++$i ) {
			$stack[$i] = $i * M_PI;
		}

		$this->assertNull( $stack["9"] );
	}

	public function testClass()
	{
		$stack = new Diskerror\Utilities\Stack;
		for ( $i = 0; $i < 100; ++$i ) {
			$stack->$i = $i * M_PI;
		}

		$this->assertEquals(100, count($stack));
		$this->assertEquals(98*M_PI, $stack->{98});
	}

	/**
	 * @depends						testClass
	 * @expectedException			DomainException
	 * @expectedExceptionMessage	Cannot unset a member.
	 */
	public function testClassUnset()
	{
		$stack = new Diskerror\Utilities\Stack;
		for ( $i = 0; $i < 6; ++$i ) {
			$stack->$i = $i * M_PI;
		}

		unset($stack->{"4"});
	}

	/**
	 * @depends	testClass
	 */
	public function testClassExistance()
	{
		$stack = new Diskerror\Utilities\Stack;
		for ( $i = 18; $i < 22; ++$i ) {
			$stack->$i = $i * M_PI;
		}

		$this->assertNull( $stack->_22 );
	}

	/**
	 * @depends	testArray
	 */
	public function testPop()
	{
		$stack = new Diskerror\Utilities\Stack;
		for ( $i = 0; $i < 5; ++$i ) {
			$stack->$i = $i * M_PI;
		}

		$this->assertEquals(4*M_PI, $stack->pop());
		$this->assertEquals(3*M_PI, $stack->pop());
		$this->assertEquals(2*M_PI, $stack->pop());
		$this->assertEquals(1*M_PI, $stack->pop());
		$this->assertEquals(0, $stack->pop());
		$this->assertNull($stack->pop());
	}

// 	public function testGetSet()
// 	{
// 		for ( $i = 11; $i < 17; ++$i ) {
// 			Diskerror\Utilities\Stack::set('_'.$i, $i * M_PI);
// 		}
//
// 		$this->assertEquals( Diskerror\Utilities\Stack::get('_13'), 13*M_PI );
//
// 		$this->assertEquals(6, count(Diskerror\Utilities\Stack::getInstance()));
//
// 		$r = Diskerror\Utilities\Stack::getInstance();
// 		$this->assertEquals( 14*M_PI, $r->_14 );
//
// 		$this->assertEquals(6, count($r));
//
// 		Diskerror\Utilities\Stack::unsetInstance();
// 		$this->assertEquals(0, count(Diskerror\Utilities\Stack::getInstance()));
// 	}

}
