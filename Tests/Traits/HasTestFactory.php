<?php


namespace calderawp\InteropFixture\Tests\Traits;

use calderawp\interop\Interfaces\InteroperableEntity;
use calderawp\InteropFixture\Entities\Entity;
use calderawp\HelloExtension\Entities\Hello;
use calderawp\InteropFixture\InteropFixture;

trait HasTestFactory
{

	/**
	 * Test entity factory that does not use container
	 *
	 * @param string $type Type of entity. Default is "HELLO". Options HELLO|
	 * @param string $id Optional. Entity ID. Default is "c42"
	 * @return Entity|Hello|InteroperableEntity
	 */
	public function entityFactory(string $type, string $id = 'c42')
	{
		switch ($type) {
			case 'oh hello!':
			case 'HELLO':
			default:
				return (new Hello())->setId($id);
		}
	}

	/**
	 * @return \calderawp\interop\CalderaForms
	 */
	protected function createApp()
	{
		return \calderawp\interop\CalderaForms::factory();
	}

	protected function helloFixturePropData() : array
	{
		$propData = [
			'who' => [
				'values' => [
					[
						'value' => InteropFixture::NO_ARG,
						'expect' => 'Roy'
					],
					[
						'value' => 'Mike',
						'expect' => 'Mike'
					],
					[
						'value' => 'mike',
						'expect' => 'Mike'
					],
				],


			],
			'triangle' => [
				'values' => [
					[
						'value' => true,
						'expect' => true
					],
					[
						'value' => false,
						'expect' => false
					],
					[
						'value' => 1,
						'expect' => true
					],
					[
						'value' => 0,
						'expect' => false
					],
					[
						'value' => 'true',
						'expect' => true
					],
					[
						'value' => 'false',
						'expect' => false
					],
				]
			]
		];
		return $propData;
	}
}
