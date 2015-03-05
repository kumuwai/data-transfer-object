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

Add data as an array:

    $dto = new DTO(['foo'=>'bar']);
    $dto['x'] = 'y';
    $dto[] = new DTO;

Add data as an object:

    $object = new StdObject;
    $object->foo = 'bar';

    $dto = new DTO($object);
    $dto->x = 'y';

You can also pass in JSON to the constructor:

    $json = "{'a':'b'}";
    $dto = new DTO($json);

You can create with a static method:

    $dto = DTO::make([...]);

View data as an object or an array:

    $dto = new DTO(['foo'=>'bar']);
    echo $dto['foo'];  // 'bar'
    echo $dto->foo;    // 'bar'

You can also count and iterate the properties:

    $dto = new DTO([...])
    $count = count($dto);
    foreach($dto as $key=>$value)
        // do something

By default, it will return an empty string if a missing property is accessed. If you would like to throw an exception when a missing property is accessed, set the default to Null.

    $dto = new DTO(['a'=>'b'], Null);
    (or)  $dto->setDefault(Null);


Installation
------------
Install the package via Composer. Edit your composer.json file as follows:

    "require": {
        "kumuwai/data-transfer-object": "dev-master"
    }

I have not put this on packagist, yet, so you'll also need to define where to get it:

    "repositories": [
        {
            "type": "vcs",
            "url":  "https://github.com/kumuwai/data-transfer-object"
        },

Next, update Composer from the terminal:

    composer update

You should be set!


TODO
-------
* Write a deeply-embedded object as json.

