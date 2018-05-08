<?php


namespace calderawp\ExampleInteropExtension;

use calderawp\ExampleInteropExtension\Traits\HelloType;
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
				\calderawp\ExampleInteropExtension\Entities\Hello::class,
				//Name of model class
				\calderawp\ExampleInteropExtension\Models\Hello::class,
				//Name of collection class
				\calderawp\ExampleInteropExtension\Collections\Hellos::class
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
