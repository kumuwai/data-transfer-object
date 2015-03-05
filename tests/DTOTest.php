<?php namespace Kumuwai\DataTransferObject;

use PHPUnit_Framework_TestCase;
use InvalidArgumentException;
use StdClass;


class DTOTest extends PHPUnit_Framework_TestCase
{
    public function testExists()
    {
        $test = new DTO;
    }

    public function testImplementsArrayAccessInterface()
    {
        $test = new DTO;
        $this->assertInstanceOf('ArrayAccess', $test);

        $test['foo'] = 'bar';
        $this->assertTrue(isset($test['foo']));
        $this->assertEquals('bar', $test['foo']);

        unset($test['foo']);
        $this->assertFalse(isset($test['foo']));
    }

    public function testCanLoadArrayInConstructor()
    {
        $test = new DTO(['foo'=>'bar']);
        $this->assertEquals('bar', $test['foo']);
    }

    public function testImplementsCountableInterface()
    {
        $test = new DTO(['a','b','c']);

        $this->assertInstanceOf('Countable', $test);
        $this->assertEquals(3, count($test));
    }

    public function testImplementsIteratorInterface()
    {
        $test = new DTO(['a'=>'foo','b'=>'bar','c'=>'cat']);

        $this->assertInstanceOf('Iterator', $test);

        $test2 = [];
        foreach($test as $key=>$value)
            $test2[] = $key.$value;

        $this->assertContains('afoo', $test2);
        $this->assertContains('bbar', $test2);
        $this->assertContains('ccat', $test2);
    }

    public function testCanLoadObjectInConstructor()
    {
        $obj = new StdClass;
        $obj->foo = 'bar';
        
        $test = new DTO($obj);
        $this->assertEquals('bar', $test['foo']);
    }

    public function testCanSetDataByName()
    {
        $test = new DTO;
        $test->foo = 'bar';

        $this->assertEquals('bar', $test['foo']);
        $this->assertEquals('bar', $test->foo);
    }

    public function testCanSetDefault()
    {
        $test = new DTO(Null, 'foo');
        $this->assertEquals('foo', $test['something-that-doesnt-exist']);

        $test->setDefault('bar');
        $this->assertEquals('bar', $test['something-that-doesnt-exist']);
    }

    /**
     * @expectedException Kumuwai\DataTransferObject\UndefinedPropertyException
     */
    public function testThrowExceptionIfNullDefault()
    {
        $test = new DTO(Null, Null);
        $a = $test->foo;
    }

    public function testReturnValuesAsSet()
    {
        $test = new DTO(['a'=>'b']);
        $this->assertTrue(isset($test->a));
        $this->assertFalse(isset($test->b));
    }

    public function testCanReturnDataAsArray()
    {
        $test = new DTO;
        $test->x = 'y';

        $this->assertEquals(['x'=>'y'], $test->toArray());
    }

    public function testCanReturnDataAsJson()
    {
        $test = new DTO(['a'=>'b']);
        $this->assertEquals('{"a":"b"}', $test->toJson());
    }

    public function testCanLoadDataAsJson()
    {
        $test = new DTO('{"a":"b"}');
        $this->assertEquals('b', $test->a);

        $json = '[{"name":"foo","keys":["first","second"]},{"name":"bar"}]';
        $test = new DTO($json);

        $this->assertEquals('foo', $test[0]['name']);
        $this->assertEquals('foo', $test[0]->name);
        $this->assertEquals('first', $test[0]->keys[0]);
        $this->assertEquals('second', $test[0]->keys[1]);

        $this->assertEquals('second', $test->get('0.keys.1'));
    }

    public function testCanLoadMultidimensionalArray()
    {
        $test = new DTO([
            array(
                'foo' => 'bar',
                'keys' => [ 'first', 'second' ]
            ),
            array(
                'name' => 'fizz',
            ),
        ]);

        $this->assertEquals('first', $test[0]->keys[0]);
        $this->assertEquals('second', $test->get('0.keys.1'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowExceptionIfInvalidConstructor()
    {
        $test = new DTO('1');
    }

    public function testCanReset()
    {
        $test = new DTO(['a']);
        $test->reset(['b']);

        $this->assertEquals('b', $test[0]);
    }

    public function testCanAddToArray()
    {
        $test = new DTO;
        $test[] = 'hi';
        $test[] = 'there';

        $this->assertContains('hi', $test);
    }    

    public function testCanConvertToAString()
    {
        $test = new DTO(['foo'=>'bar']);
        $this->assertEquals('{"foo":"bar"}', $test);
    }

    public function testCanMakeWithStaticMethod()
    {
        $test = DTO::make(['foo'=>'bar']);
        $this->assertEquals('bar', $test->foo);
    }

    // TODO: Make this work correctly
    public function testCanConvertDeeplyNestedArrayToString()
    {
        $test = new DTO([['foo'=>'bar'],['a'=>['b','c']]]);
    }

}
