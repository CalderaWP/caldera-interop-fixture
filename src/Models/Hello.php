<?php


namespace calderawp\ExampleInteropExtension\Models;

class Hello extends Model
{

	/** @inheritdoc */
	public function getEntityType()
	{
		return \calderawp\ExampleInteropExtension\Entities\Hello::class;
	}
}
