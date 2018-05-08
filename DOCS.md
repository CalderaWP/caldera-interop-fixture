# Caldera Interop Example
This is an example of how a Caldera Forms integration will work once the [caldera-interop framework](https://github.com/calderawp/caldera-interop) is integrated into the plugin. By design, these integrations MUST NOT be dependent on WordPress in anyway. They should be interoperable with the frameworks/CMSes that caldera-interop is designed to be interoperable with - Caldera Forms on WordPress, Caldera Forms Pro, Slim or any other framework that uses object representations of HTTP requests and responses following the [PHP FIG HTTP message standard.](https://github.com/php-fig/http-message)


## Making Your Own Integration
* Copy this repo.
* Find and replace `caldera-interop-extension-example` with your integration's slug.
* Find and replace `calderawp` with your vendor slug.
* Find and replace `ExampleInteropExtension` with your integration's root namespace.
* Write a bash script or something to automate that.

## Interoperable Sets
In the example, we have a Hello Entity. Entities represent a non-scalar data set in a consistent matter that can be transformed into or created from an array or HTTP message. The entity, is the first component of an "interoperable set" comprised of a related entity, model and collection. This section walks through creating each part of the set and adding it to Caldera Forms.

### Interoperable Entities
Entities, specifically the [InteroperableEntity](https://github.com/CalderaWP/caldera-interop/blob/master/src/Interfaces/InteroperableEntity.php) can optionally have validation (useful for sanitzation) and/ or automatic property casting. Our example entity impliments the [`CanCastAndValidateProps`]() interface. Therefor is can do both.
 
 For example, it casts its property "triangle" to a boolean:
 
 ```php
	/**
	 * Automatic casting for properties
	 *
	 * @var array
	 */
	protected $casts = [
		'triangle' => 'boolean'
	];
```
 
 
 It also adds validation callback to its "who" property for type-validation and string formatting:
 
 ```php
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
```
 ### Interoperable Models
 
 Entities are kind of like Eloquent Models, their attributes are always magically gettable and settable as properties. They do not have data base logic, nor does they ever act like collections. Entities SHOULD NOT have business logic beyond validation.
 
 Creating a model, specifically a [InteroperableModel](https://github.com/CalderaWP/caldera-interop/blob/master/src/Interfaces/InteroperableModel.php) defines its relationship to the entity and collection. By default models have getters and setters for the entity and collection the entity is a part of. Models also can express a valid/invalid state and communicate this via the `isValid()` method required by the interface. The model should provide its own logic here.
 
 In our example the registration is fairly auto-magic. Note how the trait [HelloType]() is used to share consistent identifiers for this data type between model, collection and entity.

Models can have business logic like database interactions and or access rights management. Entities represent data, models do things to it.

### Using The Interoperable Service Factory
Entities can becomes models:

```php
$model = $app->getFactory()->model($enity);
```

In this example, `$app` is [the main container for Caldera Forms](https://github.com/CalderaWP/caldera-interop/blob/master/src/CalderaForms.php). This container has [a special service factory](https://github.com/CalderaWP/caldera-interop/tree/master/src/Service) that creates entities, models and collections. Outside of unit tests and the factory, entities/collections/models should never be instantiated. 

Interoperable entities naturally create their own HTTP clients. Since the behaviour of the object is the same whether the data was sourced from the local database or remote HTTP API, as long as the container remains the single source of objects, whether the data lives in the same server as the code -- as opposed to be mocked in unit tests or provided by a microservice -- is functionally irrelevant to the rest of the system.

We add our set of `InteroperableEntity`, `InteroperableModel`, `CollectsEntities` to the CalderaForms "app container" using an ineroperable service, more specifically an object that impliments the [ProvidesInteropService]() interface. Our implementation is the HelloInteropService.

This allows requesting entities from the container.

A blank entity:
```php
use calderawp\ExampleInteropExtension\Entities\Hello;
$model = $app->getFactory()->entity(Hello::getType() );
```

An entity from an array:

 ```php
 use calderawp\ExampleInteropExtension\Entities\Hello;
 $model = $app->getFactory()->entity(Hello::getType(), [ 'who' => 'Mike' ] );
 ```

An entity from a [standard HTTP request](https://github.com/php-fig/http-message/blob/master/src/RequestInterface.php):

 ```php
 use calderawp\ExampleInteropExtension\Entities\Hello;
 use Psr\Http\Message\RequestInterface;
 $model = $app->getFactory()->entity(Hello::getType(), $request );
 ```
 
 Create empty collection and add entity:
 ```php
 use calderawp\ExampleInteropExtension\Entities\Hello;
$collection = $this->getFactory()->collection($entity->getTheType() );
$collection->addHello( $entity );
```
 
 ### Collections
 @TODO explain these.
 
 ## Testing
 Please see the README.md for info on installing and running tests.
 
 The `HelloInteropTest` shows how to test that the interoperable set of the Hello model, collection and entity transform properly and the entity properties are validated and casted in all contexts correctly. The `InteropFixture` class, which will get moved to its own package soon, provides a set of data that has all possible combinations of property values that we want to test. Then the unit tests check every possible combination of input value to expected value.
 
 This will all become more auto-magic soon. But the one thing you will need to create for each interop set is the $propData array that is created in the `HelloInteropTest`'s `createFixture` method. For every property of the entity, we provide an array of input values and expected outputs.
 
 ```php
$propData = [
			'nameOfProperty1' => [
				'values' => [
					[
						'value' => 'Value to pass to input',
						'expect' => 'Value to expect at output'
					],
					//etc
				],


			],
			'nameOfProperty2' => [
				'values' => [
					//etc
				]
			]
		];
```
 
 For example, we expect the "triangle" property to be true or false, but want to accept the value true as the boolean true, the integer 1 or the float 1.0 or the string "1" or the string "false". For example, to test that the string "true" when set to this property becomes the boolean `true` we pass this array:
 
 ```php
[
    'value' => 'true',
    'expect' => true
],
```

Or to confirm that our string formatting applied to the "who" property is captializing names properly:

```php
[
    'value' => 'mike',
    'expect' => 'Mike'
],
```
 
 Once these tests are properly abstracted, integration developers will only need to provide tests for their integration-specific logic.
 
 ## Adding A Processor
 @TODO Finish making this possible.
 