<?php
class DateTimeTest extends PHPUnit\Framework\TestCase
{
	public function testDateTime()
	{
		$ds = date('Y-m-d H:i:s');

		$dt = new Diskerror\Utilities\DateTime($ds);
		$this->assertEquals($ds, $dt->__toString());

		$dt = Diskerror\Utilities\DateTime::createFromFormat($ds);
		$this->assertEquals($ds, $dt->__toString());
	}

	public function testDateTimeMcs()
	{
		$ds = '2017-12-26 16:49:46.589094';

		$dt = new Diskerror\Utilities\DateTime($ds);
		$this->assertEquals($ds, $dt->__toString());

		$dt = Diskerror\Utilities\DateTime::createFromFormat($ds);
		$this->assertEquals($ds, $dt->__toString());
	}

}
