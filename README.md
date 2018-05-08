[![Build Status](https://travis-ci.org/calderawp/caldera-interop-fixture.svg?branch=master)](https://travis-ci.org/calderawp/caldera-interop-fixture)

Auto-magic tests for [caldera-interop Interoperable Servies](https://github.com/CalderaWP/caldera-interop/blob/processor/src/Service/README.md)
## Why?
* Every interoperable set MUST transform between array/entitiy/model/collection/HTTP message/ etc. consistently.
* We can only trust that claim if we test a reasonable approximation of all of the possible combination of values for an entity's properties.
* Writing all those tests takes to long.

## Install
`composer require calderawp/caldera-interop-fixture`

## Requires
* PHP 7.1

## Status
BETA
## Usage
This testing component is designed to be used with interoperable sets that are provided to the container using a `InteropProvider`. This component is comprised of two parts.

### Fixture and Prop Description
The `InteropFixture` class takes an array-like set of data `PropData` that describes the properties and possible values of an entity. The `PropData` is the least auto-magic part of this process.


#### PropData
For each property, we provide that property's name and an array of values. For example, to add a `xpLevel` prop:
 
 ```php

$propData = new PropData();
$propData->testProps = [
    'xpLevel' => [
        'values' => []
    ]
];
```
 
The `values` index collects arrays that provides an input value and an expected output value. For example, to test that the absolute value of our property is always returned:

```php
[
    'value' => -10,
    'expect' => 10
],

```

Completer example:
 
 ```php

$propData = new PropData();
$propData->testProps = [
    'xpLevel' => [
        'values' => [
            [
                'value' => -10,
                'expect' => 10
            ],
            [
                'value' => 10,
                'expect' => 10
            ],
        ]
    ],
    'otherLevel' => [
            'values' => [
                [
                    'value' => 10,
                    'expect' => 10
                ],
                [
                    'value' => 10,
                    'expect' => 10
                ],
            ]
        ]
];
```

#### `InteropFixture`
```php
use calderawp\InteropFixture\Entities\PropData;
use calderawp\InteropFixture\InteropFixture;
$fixture = new InteropFixture($propData);
```


### Using In Tests


```php
use calderawp\HelloExtension\HelloInteropService;
use calderawp\interop\CalderaForms;
use calderawp\interop\Interfaces\CalderaFormsApp;
use calderawp\InteropFixture\Entities\PropData;
/**
 * Class HelloInteropTest
 *
 * Test the example Hello interop binding
 */
class MyInteropTest extends UnitTestCase
{
	//Make fixture tests available
	use TestsInterops;


	public function testInterop()
	{
		//This provides 64 assertions for a set with two properties :)
		$this->checkFixture(
			new InteropFixture(PropData::fromArray([
				//array like examples above
			])),
			//The interoperable service provider for this set
			new SomeService(),
			//main app
			CalderaForms::factory()
		);
	}


}
```


### Complete Example
See Tests/example for an example interoperable set that is tested in by the test in tests/Unit/HelloInteropTest. This example has two properites. Both with custom validation logic. 64 assertions are generated for this set.
## Development


### Install
Requires git and Composer

* `git clone git@github.com:calderawp/caldera-interop-fixture.git`
* `cd caldera-interop-fixture`
* `composer install`

Coding Standard: Caldera (psr2 with tabs). Enforces using phpcs.

### Testing
Tests are divided between unit tests and currently no other types of tests.

#### Install
All testing dependencies are installed with composer.
#### Use
Run these commands from the plugin's root directory.

* Run All Tests and Code Formatting
    - `composer tests`
    - Includes lints, unit tests and fixes documented below
* Run Unit Tests
    - `composer unit-tests`
    - Unit tests are located in `/Tests/Unit`
* Fix All Code Formatting
    - `composer formatting`
    - Runs code sniffs and code fixes and lints.
  

## Stuff.
Copyright 2018 CalderaWP LLC. License: GPL v2 or later.
