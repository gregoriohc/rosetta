<?php

namespace Ghc\Rosetta\Messages;

class PhpObject extends Message
{
    /**
     * @return \stdClass
     */
    public function newData()
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
        return get_object_vars($this->getData());
    }

    /**
     * @param array $data
     * @return self
     */
    public function fromArray($data)
    {
        $o = $this->getData();

        foreach ($data as $key => $value) {
            $o->$key = $value;
        }

        return $this->setData($o);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return serialize($this->toArray());
    }
}