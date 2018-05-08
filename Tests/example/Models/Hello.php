<?php


namespace calderawp\HelloExtension\Models;

class Hello extends Model
{

	/** @inheritdoc */
	public function getEntityType()
	{
		return \calderawp\HelloExtension\Entities\Hello::class;
	}
}
