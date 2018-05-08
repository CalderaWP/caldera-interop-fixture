<?php


namespace calderawp\InteropFixture\Traits;

use calderawp\InteropFixture\InteropFixture;

trait TestsInterops
{

	/**
	 * Test a fixture works properly with an entity
	 *
	 * @param InteropFixture $fixture Fixture to test
	 * @param string $entityName Class ref for entity. Used as $entityName::fromArray()
	 */
	protected function checkEntityWithFixture(InteropFixture $fixture, string  $entityName)
	{
		$entityExpects = $fixture->getEntityExpects();
		$entityArrays = $fixture->getEntityArrays();
		$this->assertEquals(count($entityArrays), count($entityExpects));
		foreach ($entityArrays as $setIndex => $entityArray) {
			$entity = $entityName::fromArray($entityArray);
			$entity->setId($entityArray['id']);
			$expect =  $entityExpects[$setIndex];
			$this->checkEntity($expect, $entity, $fixture);
		}
	}

	/**
	 * Test a fixture works properly with a model
	 *
	 * @param InteropFixture $fixture Fixture to test
	 * @param string $modelName Class ref for model. Used as $modelName::fromArray()
	 */
	protected function checkModelWithFixture(InteropFixture$fixture, string $modelName)
	{
		$entityExpects = $fixture->getEntityExpects();
		$entityArrays = $fixture->getEntityArrays();
		foreach ($entityArrays as $setIndex => $entityArray) {
			$model = $modelName::fromArray($entityArray);
			$model->setId($entityArray['id']);
			$expect =  $entityExpects[$setIndex];
			$this->checkEntity($expect, $model->toEntity(), $fixture);
		}
	}

	/**
	 * Test a fixture works properly with a collection
	 *
	 * @param InteropFixture $fixture Fixture to test
	 * @param string $entityName Class ref for entity. Used as $entityName::fromArray()
	 * @param string $collectionName Class ref for collection. Used as new $colleciton()
	 */
	protected function checkCollectionWithFixture(InteropFixture$fixture, string $entityName, string $collectionName)
	{
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
	}
}
