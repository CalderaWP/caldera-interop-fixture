<?php


namespace calderawp\InteropFixture;

use calderawp\InteropFixture\Entities\PropData;

class InteropFixture
{


	const NO_ARG = 'no-argument';

	/** @var array */
	protected $propData = [];
	/** @var array */
	protected $entityExpects = [];
	/** @var array */
	protected $entityArrays = [];
	/** @var array */
	protected $propNames = [];

	/**
	 * @var PropData
	 */
	protected $propDataOriginal;

	/**
	 * InteropFixture constructor.
	 * @param PropData $propData PropData entity
	 */
	public function __construct(PropData  $propData)
	{
		//Leave copy to allow resetting from
		$this->propDataOriginal = $propData;
		//Shimmed back to an array beacuse it is not array like or itterable yet.
		$this->propData = $propData->toArray();
		$this->setProps();
	}

	/**
	 * Reset entity
	 *
	 * @return InteropFixture
	 */
	public function reset() : InteropFixture
	{
		$this->propData = $this->propDataOriginal->toArray();
		return $this;
	}

	/**
	 * Get an array of what the entities should transform to arrays as
	 *
	 * @return array
	 */
	public function getEntityExpects(): array
	{
		return $this->entityExpects;
	}

	/**
	 * Get entities arrays to use with factory for tests
	 *
	 * @return array
	 */
	public function getEntityArrays(): array
	{
		return $this->entityArrays;
	}

	/**
	 * Get the names of the entities we are testing
	 *
	 * @return array
	 */
	public function getPropNames() : array
	{
		return $this->propNames;
	}

	/**
	 * Setup the object
	 */
	private function setProps()
	{
		$this->propNames = array_keys($this->propData);
		$longestSet = 0;
		foreach ($this->propData as &$prop) {
			$values = array_column($prop['values'], 'value');
			$expects = array_column($prop['values'], 'expect');

			$valuesSetById = $this->arrayPowerSet(array_keys($values));
			foreach ($this->last($valuesSetById) as $valueIndex) {
				$prop['set'][] =
					[
						'value' => $values[$valueIndex],
						'expect' => $expects[$valueIndex]
					];
			}

			if (count($prop['set']) > $longestSet) {
				$longestSet = count($prop['set']);
			}
		}

		foreach ($this->propData as $p => &$prop) {
			$count = count($prop['set']);
			if (count($prop['set']) < $longestSet) {
				$prop['set'] = array_merge($prop['set'], array_fill(
					$count + 1,
					$longestSet - $count,
					$this->last($prop['set'])
				));
			}
		}


		$this->entityExpects = [];
		$this->entityArrays = [];

		foreach ($this->propNames as $propName) {
			for ($i = 0; $i < $longestSet; $i++) {
				if (!isset($this->entityArrays[$i])) {
					$this->entityArrays[$i] = [];
				}
				if (self::NO_ARG !== $this->propData[$propName]['set'][$i]['value']) {
					$this->entityArrays[$i][$propName] = $this->propData[$propName]['set'][$i]['value'];
				}

				$this->entityExpects[$i][$propName] = $this->propData[$propName]['set'][$i]['expect'];

				$id = md5(implode('-', array_values(
					$this->entityExpects[$i]
				)));
				$this->entityArrays[$i]['id'] = $id;
				$this->entityExpects[$i]['id'] = $id;
			}
		}
	}

	protected function last(array$array)
	{
		$key = $this->lastIndex($array);
		return isset($array[$key])?$array[$key]:null;
	}

	/**
	 * @return int|string
	 */
	protected function lastIndex(array$array)
	{
		end($array);
		return key($array);
	}

	protected function arrayPowerSet($array)
	{
		$results = [[]];

		foreach ($array as $element) {
			foreach ($results as $combination) {
				array_push($results, array_merge(array($element), $combination));
			}
		}


		return $results;
	}
}
