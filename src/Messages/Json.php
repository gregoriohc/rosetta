<?php

namespace Ghc\Rosetta\Messages;

class Json extends Message
{
    /**
     * @return string
     */
    public function newData()
    {
        return '{}';
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->getData(), true);
    }

    /**
     * @param array $data
     * @return self
     */
    public function fromArray($data)
    {
        return $this->setData(json_encode($data));
    }
}