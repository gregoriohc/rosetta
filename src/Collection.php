<?php

namespace Ghc\Rosetta;

class Collection extends Item
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect($this->data)->map(function($itemData) {
            return (new Item($itemData, $this->transformers))->toArray();
        })->toArray();
    }
}
