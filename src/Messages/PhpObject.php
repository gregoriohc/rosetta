<?php

namespace Ghc\Rosetta\Messages;

class PhpObject extends Message
{
    /**
     * @return \stdClass
     */
    public function new()
    {
        return new \stdClass();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this->get());
    }

    /**
     * @param array $data
     * @return self
     */
    public function fromArray($data)
    {
        $o = $this->get();

        foreach ($data as $key => $value) {
            $o->$key = $value;
        }

        return $this->set($o);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return serialize($this->toArray());
    }
}