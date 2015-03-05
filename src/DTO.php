<?php namespace Kumuwai\DataTransferObject;

use InvalidArgumentException;
use ArrayAccess;
use Countable;
use Iterator;


class DTO implements ArrayAccess, Countable, Iterator
{
    protected $data;
    protected $pointer;
    protected $keys;
    protected $default;

    public function __construct($data=[], $default='')
    {
        $this->default = $default;

        $this->reset($data);
    }

    public static function make($data=[], $default='')
    {
        return new static($data, $default);
    }

    public function reset($data)
    {
        $this->pointer = 0;
        $this->keys = Null;
        $this->data = [];

        if (is_array($data))
            return $this->data = $this->loadArrayObjects($data);

        if (is_object($data))
            return $this->data = (array) $data;

        if (is_string($data)) {
            $json = json_decode($data, true);
            if ( is_array($json) )
                return $this->data = $this->loadArrayObjects($json);
        }

        throw new InvalidArgumentException('Please use an array to initialize this class');
    }

    private function loadArrayObjects($array)
    {
        $data = [];

        foreach ($array as $key=>$value)
            if (is_array($value))
                $data[$key] = new DTO($this->loadArrayObjects($value));
            else
                $data[$key] = $value;

        return $data;
    }

    /**
     * Retrieve a given value from a deeply nested array using "dot" notation
     * 
     * @param  string $path     The dot notation value to search for (eg, path.to.key)
     */
    public function get($path, $default=Null)
    {
        $current = $this->data;
        $p = strtok($path, '.');

        while ($p !== false) {
            if (!isset($current[$p])) {
                return is_null($default) ? $this->getDefault($path) : $default;
            }
            $current = $current[$p];
            $p = strtok('.');
        }

        return $current;
    }

    public function offsetExists($key)
    {
        return isset($this->data[$key]);
    }

    public function offsetGet($key)
    {
        if (isset($this->data[$key]))
            return $this->data[$key];

        return $this->getDefault($key);
    }

    protected function getDefault($key)
    {
        if (is_null($this->default))
            throw new UndefinedPropertyException("Property $key is not defined");

        return $this->default;
    }

    public function setDefault($value)
    {
        $this->default = $value;
    }

    public function offsetSet($key, $value)
    {
        $this->keys = Null;

        if (is_null($key)) {
            $this->data[] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }

    public function offsetUnset($key)
    {
        $this->keys = Null;
        unset($this->data[$key]);
    }

    public function count()
    {
        return count($this->data);
    }

    public function current()
    {
        $key = $this->getKeys()[$this->pointer];
        return $this->data[$key];
    }

    public function key()
    {
        return $this->getKeys()[$this->pointer];
    }

    public function next()
    {
        $this->pointer ++;
    }

    public function rewind()
    {
        $this->pointer = 0;
    }

    public function valid()
    {
        $keys = $this->getKeys();
        return isset($keys[$this->pointer]);
    }

    protected function getKeys()
    {
        if ( ! $this->keys)
            $this->keys = array_keys($this->data);

        return $this->keys;
    }

    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function toArray()
    {
        return array_map(function($value) {
            if (is_object($value) && method_exists($value, 'toArray'))
                return $value->toArray();
            return $value;
        }, $this->data);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

}
