<?php

class Container implements \ArrayAccess
{
    private $container = array();

    public function __construct()
    {
        ;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            return new \Exception('null is not available for offset');
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetGet($offset)
    {
        $val = $this->container[$offset];

        if (is_object($this->container[$offset])) {
            $val = $val($this);
        }

        return $val;
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}
