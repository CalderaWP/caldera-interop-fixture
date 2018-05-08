<?php


namespace calderawp\InteropFixture\Tests\Traits;

use calderawp\InteropFixture\Entities\Entity;
use calderawp\InteropFixture\Entities\Hello;

trait HasTestFactory
{


	/**
	 * Test entity factory that does not use container
	 *
	 * @param string $type Type of entity. Default is "HELLO". Options HELLO|
	 * @param string $id Optional. Entity ID. Default is "c42"
	 * @return Entity
	 */
	public function entityFactory(string $type, string $id = 'c42')
	{
		switch ($type) {
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
}
