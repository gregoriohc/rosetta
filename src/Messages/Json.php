<?php

namespace Ghc\Rosetta\Messages;

class Json extends Message
{
    /**
     * @return string
     */
    public function new()
    {
        return '';
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->get());
    }

    /**
     * @param array $data
     * @return self
     */
    public function fromArray($data)
    {
        return $this->set(json_encode($data));
    }
}