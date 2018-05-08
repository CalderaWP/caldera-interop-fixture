<?php


namespace calderawp\InteropFixture\Tests\Unit;

use calderawp\HelloExtension\HelloInteropService;
use calderawp\InteropFixture\Entities\PropData;
use calderawp\InteropFixture\InteropFixture;
use calderawp\InteropFixture\Traits\TestsInterops;

/**
 * Class HelloInteropTest
 *
 * Test the example Hello interop binding
 */
class HelloInteropTest extends UnitTestCase
{
	use TestsInterops;

	/**
	 * Test the interop binding
	 *
	 * @covers HelloInteropService()
	 * @covers \calderawp\HelloExtension\Models\Hello()
	 * @covers \calderawp\HelloExtension\Entities\Hello()
	 * @covers \calderawp\HelloExtension\Collections\Hellos()
	 */
	public function testInterop()
	{
		//This provides 64 assertions for a set with two properties :)
		$this->checkFixture($this->createFixture(), new HelloInteropService(), $this->createApp());
	}

	/**
	 * @return InteropFixture
	 */
	protected function createFixture(): InteropFixture
	{
		$fixture = new InteropFixture(PropData::fromArray($this->helloFixturePropData()));
		return $fixture;
	}
}


