<?php


namespace calderawp\InteropFixture\Tests\Unit;

use calderawp\HelloExtension\Entities\Hello;
use calderawp\HelloExtension\Collections\Hellos as HelloCollection;
use calderawp\HelloExtension\HelloInteropService;
use calderawp\HelloExtension\Models\Hello as HelloModel;
use calderawp\InteropFixture\Entities\PropData;
use calderawp\InteropFixture\InteropFixture;
use calderawp\InteropFixture\Traits\TestsInterops;

class HelloInteropTest extends UnitTestCase
{
	use TestsInterops;

	/**
	 * Test Entity
	 */
	public function testEntity()
	{
		$fixture = $this->createFixture();
		$entityName = Hello::class;
		$this->checkEntityWithFixture($fixture, $entityName);
	}

	/**
	 * Test hello model
	 */
	public function testModel()
	{
		$fixture = $this->createFixture();
		$modelName = HelloModel::class;
		$this->checkModelWithFixture($fixture, $modelName);
	}

	/**
	 * Test collecting Hellos
	 */
	public function testCollection()
	{
		$fixture = $this->createFixture();
		$entityName = Hello::class;
		$collectionName = HelloCollection::class;
		$this->checkCollectionWithFixture($fixture, $entityName, $collectionName);
	}


	/**
	 * @return InteropFixture
	 */
	protected function createFixture(): InteropFixture
	{
		$fixture = new InteropFixture(
			PropData::fromArray($this->helloFixturePropData())
		);
		return $fixture;
	}


	/**
	 *
	 * @covers CalderaForms::registerInterops()
	 * @covers CalderaForms::getFactory()
	 */
	public function testFactory()
	{
		$calderaForms = $this->createApp();

		$service = new HelloInteropService();
		$service->bindInterop($calderaForms);
		$this->assertSame(
			Hello::class,
			get_class(
				$calderaForms
					->getFactory()
					->entity(HelloInteropService::getType())
			)
		);
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
}
