<?php


namespace calderawp\InteropFixture\Tests\Unit;

use calderawp\HelloExtension\HelloInteropService;
use calderawp\InteropFixture\Entities\PropData;
use calderawp\InteropFixture\InteropFixture;
use calderawp\InteropFixture\Traits\TestsInterops;

class HelloInteropTest extends UnitTestCase
{
	use TestsInterops;

	public function testInterop()
	{
		$this->checkFixture($this->createFixture(), new HelloInteropService(), $this->createApp());
	}

	/**
	 * @return InteropFixture
	 */
	protected function createFixture(): InteropFixture
	{
		$fixture = new InteropFixture(
			PropData::fromArray($this->helloFixturePropData())
		);
		return $fixture;
	}
}
