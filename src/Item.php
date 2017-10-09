<?php

namespace Ghc\Rosetta;

use Ghc\Rosetta\Transformers\None;
use Ghc\Rosetta\Transformers\Transformer;
use Illuminate\Contracts\Support\Arrayable;

class Item implements Arrayable
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var Transformer[]
     */
    protected $transformers;

    /**
     * Item constructor.
     * @param array|mixed $data
     * @param Transformer[] $transformers
     */
    public function __construct($data, $transformers = null)
    {
        $this->data = (array) $data;
        $this->transformers = $transformers ?: new None;
        $this->transformers = is_array($this->transformers) ? $this->transformers : [$this->transformers];
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = $this->data;

        foreach ($this->transformers as $transformer) {
            $data =
                $transformer->transform($data) +
                $transformer->processRelations($data);
        }

        return $data;
    }
}
