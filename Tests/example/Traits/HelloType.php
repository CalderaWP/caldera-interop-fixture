<?php


namespace calderawp\HelloExtension\Traits;

/**
 * Trait for entity/model/collection to use to identify common type.
 *
 * Single source of string identifier for this entity/model/collection set.
 */
trait HelloType
{

	/** @inheritdoc */
	public static function getType()
	{
		return 'cf.addon.hello';
	}

	/** @inheritdoc */
	public function getTheType()
	{
		return 'cf.addon.hello';
	}
}
