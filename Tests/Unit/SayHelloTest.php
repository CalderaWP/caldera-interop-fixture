<?php


namespace calderawp\ExampleInteropExtension\Tests\Unit;

use calderawp\ExampleInteropExtension\SayHello;

/**
 * Coverage for the example class
 */
class SayHelloTest extends UnitTestCase
{

	/**
	 * Test default values of function
	 *
	 * @covers SayHello::sayHi()
	 */
	public function testHiRoy()
	{
		$this->assertEquals('Hi Roy', (new SayHello())->sayHi());
	}

	/**
	 * Test function argument
	 *
	 * @covers SayHello::sayHi()
	 */
	public function testHiMike()
	{
		$this->assertEquals('Hi Mike', (new SayHello())->sayHi('Mike'));
	}
}
