<?php namespace Kumuwai\DataTransferObject;

use Iterator;


class DTOIterator implements Iterator
{
    private $data;
    protected $pointer;

    public function __construct($data)
    {
        $this->data = $data;
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

    public function getKeys()
    {
        return array_keys($this->data);
    }

}
