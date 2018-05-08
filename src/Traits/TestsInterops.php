<?php


namespace calderawp\InteropFixture\Traits;

use calderawp\interop\Interfaces\CalderaFormsApp;
use calderawp\interop\Interfaces\ProvidesInteropService;
use calderawp\interop\Providers\InteropProvider;
use calderawp\InteropFixture\InteropFixture;

trait TestsInterops
{

	/**
	 * @var InteropFixture
	 */
	protected $fixture;

	/**
	 * @var CalderaFormsApp
	 */
	private $calderaFormsApp;

	private $entityName;
	private $modelName;
	private $collectioName;
	/**
	 * Test a fixture
	 *
	 * @param InteropFixture $fixture Fixture to test set with
	 * @param InteropProvider $provider Service provider for set
	 *
	 * @return  $this;
	 */
	protected function checkFixture(
		InteropFixture $fixture,
		InteropProvider $provider,
		CalderaFormsApp $calderaFormsApp
	) {
		$this->calderaFormsApp = $calderaFormsApp;
		$this->fixture = $fixture;
		$this->entityName = $provider->getEntityClassRef();
		$this->modelName = $provider->getModelClassRef();
		$this->collectioName = $provider->getCollectionClassRef();
		$this->
			checkEntityWithFixture($fixture)
			->reset()
			->checkModelWithFixture($fixture)
			->reset()
			->checkCollectionWithFixture($fixture)
			->checkFactory($provider);
		return $this;
	}

	private function reset()
	{
		$this->fixture->reset();
		return $this;
	}

	/**
	 * Test a fixture works properly with an entity
	 *
	 * @param InteropFixture $fixture Fixture to test
	 * @return  $this;
	 */
	protected function checkEntityWithFixture(InteropFixture $fixture)
	{
		$entityName = $this->entityName;
		$entityExpects = $fixture->getEntityExpects();
		$entityArrays = $fixture->getEntityArrays();
		$this->assertEquals(count($entityArrays), count($entityExpects));
		foreach ($entityArrays as $setIndex => $entityArray) {
			$entity = $entityName::fromArray($entityArray);
			$entity->setId($entityArray['id']);
			$expect =  $entityExpects[$setIndex];
			$this->checkEntity($expect, $entity, $fixture);
		}
		return $this;
	}

	/**
	 * @param $expect
	 * @param $entity
	 * @param $fixture
	 */
	protected function checkEntity($expect, $entity, $fixture): void
	{
		$this->assertEquals($expect, $entity->toArray());

		foreach ($fixture->getPropNames() as $propName) {
			$this->assertEquals($expect[$propName], $entity->$propName);
		}

		$this->assertEquals(
			$expect,
			\GuzzleHttp\json_decode($entity->toResponse()->getBody()->getContents(), true)
		);
	}

	/**
	 * Test a fixture works properly with a model
	 *
	 * @param InteropFixture $fixture Fixture to test
	 *
	 * @return  $this;
	 */
	protected function checkModelWithFixture(InteropFixture$fixture)
	{
		$modelName = $this->modelName;
		$entityExpects = $fixture->getEntityExpects();
		$entityArrays = $fixture->getEntityArrays();
		foreach ($entityArrays as $setIndex => $entityArray) {
			$model = $modelName::fromArray($entityArray);
			$model->setId($entityArray['id']);
			$expect =  $entityExpects[$setIndex];
			$this->checkEntity($expect, $model->toEntity(), $fixture);
		}
		return $this;
	}

	/**
	 * Test a fixture works properly with a collection
	 *
	 * @param InteropFixture $fixture Fixture to test
	 * @return  $this;
	 */
	protected function checkCollectionWithFixture(InteropFixture$fixture)
	{
		$entityName = $this->entityName;
		$collectionName = $this->collectioName;
		$entityArrays = $fixture->getEntityArrays();
		$collection = new $collectionName();
		foreach ($entityArrays as $setIndex => $entityArray) {
			$entity = $entityName::fromArray($entityArray);
			$entity->setId($entityArray['id']);
			$collection->addHello($entity);
		}

		foreach ($entityArrays as $entityA) {
			$this->assertTrue($collection->has($entityA['id']));
			$entity = $collection->getHello($entityA['id']);
			$this->assertEquals($entityName::fromArray($entityA), $entity);
		}
		return $this;
	}

	/**
	 * @param ProvidesInteropService $service
	 * @return $this
	 */
	protected function checkFactory(ProvidesInteropService $service)
	{
		$entityName = $this->entityName;

		$service->bindInterop($this->calderaFormsApp);
		$this->assertSame(
			$entityName,
			get_class(
				$this->calderaFormsApp
					->getFactory()
					->entity($service->getAlias())
			)
		);

		return $this;
	}
}
