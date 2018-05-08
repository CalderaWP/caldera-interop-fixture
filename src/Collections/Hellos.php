<?php


namespace calderawp\ExampleInteropExtension\Collections;

use calderawp\ExampleInteropExtension\Entities\Hello;

class Hellos extends Collection
{
	/**
	 * @inheritDoc
	 */
	public function getEntityGetter()
	{
		return 'addHello';
	}

	/**
	 * @inheritDoc
	 */
	public function getEntitySetter()
	{
		return 'getHello';
	}


	public function addHello(Hello $hello)
	{
		$this->addEntity($hello);
	}

	public function getHello($id)
	{
		return $this->getEntity($id);
	}
	/**
	 * @inheritDoc
	 */
	public function getEntityType()
	{
		return Hello::class;
	}
}
