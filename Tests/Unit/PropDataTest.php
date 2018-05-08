<?php


namespace calderawp\InteropFixture\Tests\Unit;

use calderawp\InteropFixture\Entities\PropData;

class PropDataTest extends UnitTestCase
{

	/**
	 * Test the propData prop
	 *
	 * @covers PropData::$propData
	 * @covers PropData::fromArray()
	 * @covers PropData::toArray()
	 */
	public function testPropData()
	{
		$entity =  PropData::fromArray($this->helloFixturePropData());
		$this->assertFalse(is_array($entity));
		$this->assertEquals(
			$this->helloFixturePropData(),
			$entity->toArray()
		);
	}
}
