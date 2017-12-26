<?php
class SingletonTest extends PHPUnit\Framework\TestCase
{
	public function testConstruct()
	{
		$reflection = new \ReflectionClass('SingletonInstance');
		$this->assertFalse( $reflection->getConstructor()->isPublic() );
	}

	public function testClone()
	{
		$reflection = new \ReflectionClass('SingletonInstance');
		$this->assertFalse( $reflection->isCloneable() );
	}

	public function testExistance()
	{
		$s = SingletonInstance::getInstance();
		$this->assertEquals( $s, Diskerror\Utilities\Registry::get('SingletonInstance') );
	}

}

class SingletonInstance extends Diskerror\Utilities\Singleton
{
	public $someVar = 'and text';
}
