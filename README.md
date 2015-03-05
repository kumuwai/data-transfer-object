<p>
<a href="mailto://joel@kumuwai.com"><img src="http://img.shields.io/badge/author-joel-blue.svg" alt="Author"></a>
<a href="https://github.com/kumuwai/data-transfer-object"><img src="http://img.shields.io/badge/source-kumuwai%2Fdata--transfer--object-blue.svg" alt="Source Code"></a>
<a href="LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="Software License"></a>
<br>
<a href="https://travis-ci.org/kumuwai/data-transfer-object"><img src="https://img.shields.io/travis/kumuwai/data-transfer-object/master.svg" alt="Build Status"></a>
<a href='https://coveralls.io/r/kumuwai/data-transfer-object'><img src='https://coveralls.io/repos/kumuwai/data-transfer-object/badge.svg' alt='Coverage Status' /></a>
<a href="https://scrutinizer-ci.com/g/kumuwai/data-transfer-object"><img src="https://img.shields.io/scrutinizer/g/kumuwai/data-transfer-object.svg" alt="Quality Score"></a>
</p>


DataTransferObject
===================
This class provides a simple data transfer object. It's designed to make it easy to add and view data. 

You can instantiate the class with an array, arrayable object, or json string. These are all equivalent:

    $object = new StdObject;
    $object->foo = 'bar';

    $dto = new DTO($object);
    $dto = new DTO(['foo'=>'bar']);
    $dto = new DTO('{"foo":"bar"}');

    $dto = DTO::make($object);
    $dto = DTO::make(['foo'=>'bar']);
    $dto = DTO::make('{"foo":"bar"}');

Read data with array, object, or dot notation:

    echo $dto['x'];
    echo $dto->x;
    echo $dto->get('x');

These will also handle nested sets:

    echo $dto['x']['y']['z'];
    echo $dto->x->y->z;
    echo $dto->get('x.y.z');

By default, it will return an empty string if a missing property is accessed. If you would like to throw an exception when a missing property is accessed, set the default to Null.

    $dto = new DTO(['a'=>'b'], Null);
    (or)  $dto->setDefault(Null);

By default, an empty string will be returned if a missing property is accessed. Other possibilities:

    $dto = new DTO([], 'x');            // instantiate with a given default
    $dto->setDefault('x');              // change the default
    $dto->get('path.to.key', 'x');      // override the default for this method call only
    $dto->setDefault(Null);             // throw an exception instead of returning a value

Add new data with array or object notation:

    $dto['x'] = 'y';
    $dto->x = 'y';

Count and iterate the properties:

    $dto = new DTO([...])
    $count = count($dto);
    foreach($dto as $key=>$value)
        // do something


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
