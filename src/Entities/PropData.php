<?php


namespace calderawp\InteropFixture\Entities;

use calderawp\interop\Traits\CanCastAndValidateProps;
use calderawp\InteropFixture\Traits\PropDataType;

class PropData extends Entity
{

	use PropDataType, CanCastAndValidateProps;

	/**
	 * @var array
	 */
	protected $testProps;

	protected $casts = [
		'testProps' => 'array'
	];

	/** @inheritdoc */
	public function toArray()
	{
		return $this->testProps;
	}

	/** @inheritdoc */
	public static function fromArray(array $items)
	{
		$obj = new static();
		$obj->testProps = $items;
		return $obj;
	}
}
