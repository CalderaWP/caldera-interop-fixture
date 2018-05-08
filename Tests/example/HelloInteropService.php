<?php


namespace calderawp\HelloExtension;

use calderawp\HelloExtension\Traits\HelloType;
use calderawp\interop\Interfaces\CalderaFormsApp;
use calderawp\interop\Interfaces\ProvidesInteropService;

/**
 * Class HelloInteropService
 *
 * Makes the Hello entity, model and collection avail by the interoperable service container of Caldera Forms
 */
class HelloInteropService implements ProvidesInteropService
{
	//Trait defines the entity type
	use HelloType;

	/** @inheritdoc */
	public function bindInterop(CalderaFormsApp $calderaFormsApp)
	{
		$calderaFormsApp
			->getFactory()
			->bindInterop(
				//Alias that identifies these objects in container
				$this->getAlias(),
				//Name of entity class
				\calderawp\HelloExtension\Entities\Hello::class,
				//Name of model class
				\calderawp\HelloExtension\Models\Hello::class,
				//Name of collection class
				\calderawp\HelloExtension\Collections\Hellos::class
			);

		return $this;
	}

	/** @inheritdoc */
	public function getAlias()
	{
		//Use a consistent identifier defined in the type trait.
		return $this->getTheType();
	}
}
