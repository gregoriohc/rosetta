<?php

namespace Ghc\Rosetta\Messages;

class PhpArray extends Message
{
    /**
     * @return array
     */
    public function newData()
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
        return $this->getData();
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public function fromArray($data)
    {
        return $this->setData($data);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return serialize($this->toArray());
    }
}
