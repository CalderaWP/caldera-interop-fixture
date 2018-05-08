<?php


namespace calderawp\InteropFixture\Traits;

trait PropDataType
{


	/** @inheritdoc */
	public static function getType()
	{
		return 'cf.testing.PropDataType';
	}

	/** @inheritdoc */
	public function getTheType()
	{
		return 'cf.testing.PropDataType';
	}
}
