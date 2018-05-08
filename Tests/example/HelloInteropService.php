<?php


namespace calderawp\HelloExtension;

use calderawp\HelloExtension\Traits\HelloType;
use calderawp\interop\Interfaces\CalderaFormsApp;
use calderawp\interop\Interfaces\ProvidesInteropService;
use calderawp\interop\Providers\InteropProvider;

/**
 * Class HelloInteropService
 *
 * Makes the Hello entity, model and collection avail by the interoperable service container of Caldera Forms
 */
class HelloInteropService extends InteropProvider
{
	//Trait defines the entity type
	use HelloType;


	/** @inheritdoc */
	public function getAlias()
	{
		//Use a consistent identifier defined in the type trait.
		return $this->getTheType();
	}


	/** @inheritdoc */
	public function getEntityClassRef()
	{
		return \calderawp\HelloExtension\Entities\Hello::class;
	}

	/** @inheritdoc */
	public function getModelClassRef()
	{
		return \calderawp\HelloExtension\Models\Hello::class;
	}

	/** @inheritdoc */
	public function getCollectionClassRef()
	{
		return \calderawp\HelloExtension\Collections\Hellos::class;
	}
}
