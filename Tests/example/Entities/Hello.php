<?php
namespace  calderawp\HelloExtension\Entities;

use calderawp\HelloExtension\Traits\HelloType;
use calderawp\interop\Traits\CanCastAndValidateProps;

class Hello extends Entity
{

	use HelloType,CanCastAndValidateProps;

	/**
	 * @var string
	 */
	protected $who;


	/**
	 * @var bool
	 */
	protected $triangle;

	/**
	 * Automatic casting for properties
	 *
	 * @var array
	 */
	protected $casts = [
		'triangle' => 'boolean'
	];


	/**
	 * Validate and format "who" property.
	 *
	 * @param string $value New value to set
	 * @return string
	 */
	protected function validateWho($value)
	{

		//If invalid, set to default
		if (is_null($value) || ! is_string($value) || empty($value)) {
			$value = 'Roy';
		}
		//Format string
		return ucwords($value);
	}
}
