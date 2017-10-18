<?php

namespace Ghc\Rosetta;

use Ghc\Rosetta\Pipes\Pipeable;

class Collection extends Item implements Pipeable
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect($this->getData())->map(function ($itemData) {
            return (new Item($itemData, $this->transformers))->toArray();
        })->toArray();
    }
}
