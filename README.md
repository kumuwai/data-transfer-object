DataTransferObject
===================
[![Latest Stable Version](https://img.shields.io/packagist/v/kumuwai/data-transfer-object.svg)](https://packagist.org/packages/kumuwai/data-transfer-object)
[![Build Status](https://img.shields.io/travis/kumuwai/data-transfer-object/master.svg)](https://travis-ci.org/kumuwai/data-transfer-object)
[![Coverage Status](https://coveralls.io/repos/kumuwai/data-transfer-object/badge.png?branch=master)](https://coveralls.io/r/kumuwai/data-transfer-object)
[![Quality Score](https://img.shields.io/scrutinizer/g/kumuwai/data-transfer-object.svg)](https://scrutinizer-ci.com/g/kumuwai/data-transfer-object)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)


This class is designed to make it easy to add and view data. Load objects, arrays, or json; read with object, array, or dot notation; output to json string.

Usage
------
You can instantiate the class with an array, arrayable object, or json string. These are all equivalent:

```php
$object = new StdObject;
$object->foo = 'bar';

$dto = new DTO($object);
$dto = new DTO(['foo'=>'bar']);
$dto = new DTO('{"foo":"bar"}');

$dto = DTO::make($object);
$dto = DTO::make(['foo'=>'bar']);
$dto = DTO::make('{"foo":"bar"}');
```

Read data with array, object, or dot notation:

```php
echo $dto['x'];
echo $dto->x;
echo $dto->get('x');
```

These will also handle nested sets:

```php
echo $dto['x']['y']['z'];
echo $dto->x->y->z;
echo $dto->get('x.y.z');
```

By default, an empty string will be returned if a missing property is accessed. Other possibilities:

```php
$dto = new DTO([], 'x');            // instantiate with a given default
$dto->setDefault('x');              // change the default
$dto->get('path.to.key', 'x');      // override default for this method call
$dto->setDefault(Null);             // throw an UndefinedProperty exception
```

Add new data with array or object notation:

```php
$dto['x'] = 'y';
$dto->x = 'y';
```

Count and iterate the properties:

```php
$dto = new DTO([...])
$count = count($dto);
foreach($dto as $key=>$value)
    // do something
```

Laravel Support
----------------
There are two versions of the data transfer object that implement Laravel-specific interfaces. Use one of these classes if you want Laravel to work with DTOs as first-class Laravel objects.

* Laravel4DTO implements JsonableInterface and ArrayableInterface
* Laravel5DTO implements Jsonable and Arrayable

You can use these to sanitize output before you send it to a view, eg:

```php
$models = Model::all();
$output = [];
foreach($models as $model)
    $output[] = new Laravel4DTO([
        'name' => $model->name,
        'paid' => $model->payments->sum('payment_amount'),
        ...
    ]);
return new Collection($output);
```

Installation
------------
Install the package via Composer. Edit your composer.json file as follows:

    "require": {
        "kumuwai/data-transfer-object": "dev-master"
    }

Next, update Composer from the terminal:

    composer update



TODO
-------
None at this time
