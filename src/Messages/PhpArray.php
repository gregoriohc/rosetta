<?php

namespace Ghc\Rosetta\Messages;

class PhpArray extends Message
{
    /**
     * @return array
     */
    public function new()
    {
        return [];
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->get();
    }

    /**
     * @param array $data
     * @return self
     */
    public function fromArray($data)
    {
        return $this->set($data);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return serialize($this->toArray());
    }
}