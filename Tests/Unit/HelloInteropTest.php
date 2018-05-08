<?php


namespace calderawp\InteropFixture\Tests\Unit;

use calderawp\HelloExtension\Entities\Hello;
use calderawp\HelloExtension\Collections\Hellos as HelloCollection;
use calderawp\HelloExtension\HelloInteropService;
use calderawp\HelloExtension\Models\Hello as HelloModel;

class HelloInteropTest extends UnitTestCase
{


	/**
	 * Test Entity
	 */
	public function testEntity()
	{
		$fixture = $this->createFixture();

		$entityExpects = $fixture->getEntityExpects();
		$entityArrays = $fixture->getEntityArrays();
		$this->assertEquals(count($entityArrays), count($entityExpects));
		foreach ($entityArrays as $setIndex => $entityArray) {
			$entity = Hello::fromArray($entityArray);
			$entity->setId($entityArray['id']);
			$expect =  $entityExpects[$setIndex];
			$this->checkEntity($expect, $entity, $fixture);
		}
	}


	/**
	 * Test hello model
	 */
	public function testModel()
	{
		$fixture = $this->createFixture();
		$entityExpects = $fixture->getEntityExpects();
		$entityArrays = $fixture->getEntityArrays();
		foreach ($entityArrays as $setIndex => $entityArray) {
			$model = HelloModel::fromArray($entityArray);
			$model->setId($entityArray['id']);
			$expect =  $entityExpects[$setIndex];
			$this->checkEntity($expect, $model->toEntity(), $fixture);
		}
	}

	/**
	 * Test collecting Hellos
	 */
	public function testCollection()
	{
		$fixture = $this->createFixture();
		$entityArrays = $fixture->getEntityArrays();
		$collection = new HelloCollection();
		foreach ($entityArrays as $setIndex => $entityArray) {
			$entity = Hello::fromArray($entityArray);
			$entity->setId($entityArray['id']);
			$collection->addHello($entity);
		}

		foreach ($entityArrays as $entityA) {
			$this->assertTrue($collection->has($entityA['id']));
			$entity = $collection->getHello($entityA['id']);
			$this->assertEquals(Hello::fromArray($entityA), $entity);
		}
	}



	/**
	 * @return InteropFixture
	 */
	protected function createFixture(): InteropFixture
	{
		$propData = [
			'who' => [
				'values' => [
					[
						'value' => InteropFixture::NO_ARG,
						'expect' => 'Roy'
					],
					[
						'value' => 'Mike',
						'expect' => 'Mike'
					],
					[
						'value' => 'mike',
						'expect' => 'Mike'
					],
				],


			],
			'triangle' => [
				'values' => [
					[
						'value' => true,
						'expect' => true
					],
					[
						'value' => false,
						'expect' => false
					],
					[
						'value' => 1,
						'expect' => true
					],
					[
						'value' => 0,
						'expect' => false
					],
					[
						'value' => 'true',
						'expect' => true
					],
					[
						'value' => 'false',
						'expect' => false
					],
				]
			]
		];

		$fixture = new InteropFixture($propData);
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
