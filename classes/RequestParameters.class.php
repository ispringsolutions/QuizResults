<?php

class RequestParameters implements ArrayAccess, Countable
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function offsetExists($offset)
    {
        return isset($this->params[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? trim($this->params[$offset]) : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->params[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->params[$offset]);
    }

    public function count()
    {
        return count($this->params);
    }
}
