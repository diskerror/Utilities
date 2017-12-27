<?php
class RegistryTest extends PHPUnit\Framework\TestCase
{
	public function testArray()
	{
		$registry = new Diskerror\Utilities\Registry;
		for ( $i = 0; $i < 100; ++$i ) {
			$registry[$i] = $i * M_PI;
		}

		$this->assertTrue( isset($registry[95]) );
		$this->assertFalse( isset($registry[105]) );

		$this->assertEquals(100, count($registry));
		$this->assertEquals(99*M_PI, $registry[99]);
	}

	/**
	 * @depends						testArray
	 * @expectedException			DomainException
	 * @expectedExceptionMessage	Cannot unset a member.
	 */
	public function testArrayUnset()
	{
		$registry = new Diskerror\Utilities\Registry;
		for ( $i = 0; $i < 6; ++$i ) {
			$registry[$i] = $i * M_PI;
		}

		unset($registry[4]);
	}

	/**
	 * @depends				testArray
	 */
	public function testArrayExistance()
	{
		$registry = new Diskerror\Utilities\Registry;
		for ( $i = 5; $i < 8; ++$i ) {
			$registry[$i] = $i * M_PI;
		}

		$this->assertNull( $registry["9"] );
	}

	/**
	 * @depends	testArrayExistance
	 */
	public function testPop()
	{
		$registry = new Diskerror\Utilities\Registry;
		for ( $i = 0; $i < 5; ++$i ) {
			$registry->$i = $i * M_PI;
		}

		$this->assertEquals(4*M_PI, $registry->pop());
		$this->assertEquals(3*M_PI, $registry->pop());
		$this->assertEquals(2*M_PI, $registry->pop());
		$this->assertEquals(1*M_PI, $registry->pop());
		$this->assertEquals(0, $registry->pop());
		$this->assertNull($registry->pop());
	}

	public function testGetSet()
	{
		for ( $i = 11; $i < 17; ++$i ) {
			Diskerror\Utilities\Registry::set('_'.$i, $i * M_PI);
		}

		$this->assertEquals( Diskerror\Utilities\Registry::get('_13'), 13*M_PI );

		$this->assertEquals(6, count(Diskerror\Utilities\Registry::getInstance()));

		$r = Diskerror\Utilities\Registry::getInstance();
		$this->assertEquals( 14*M_PI, $r->_14 );

		$this->assertEquals(6, count($r));

		Diskerror\Utilities\Registry::unsetInstance();
		$this->assertEquals(0, count(Diskerror\Utilities\Registry::getInstance()));
	}

}
