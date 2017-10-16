<?php

namespace Ghc\Rosetta;

use Ghc\Rosetta\Transformers\Skip;
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
     * @param Transformer|Transformer[] $transformers
     */
    public function __construct($data = [], $transformers = null)
    {
        $this->setData($data);
        $this->setTransformers($transformers);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array|mixed $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = (array) $data;

        return $this;
    }

    /**
     * @return Transformers\Transformer[]
     */
    public function getTransformers()
    {
        return $this->transformers;
    }

    /**
     * @param Transformers\Transformer|Transformers\Transformer[] $transformers
     * @return self
     */
    public function setTransformers($transformers)
    {
        $transformers = $transformers ?: new Skip;
        $this->transformers = is_array($transformers) ? $transformers : [$transformers];

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = $this->getData();

        foreach ($this->transformers as $transformer) {
            $data =
                $transformer->transform($data) +
                $transformer->processRelations($data);
        }

        return $data;
    }

    /**
     * @param array $options
     * @return \Closure
     */
    public function pipe($options = [])
    {
        return function($inputData) use ($options) {
            $this->setData($inputData);
            return $this->toArray();
        };
    }
}
