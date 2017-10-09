<?php

namespace Ghc\Rosetta\Transformers;

class None extends Transformer
{
    /**
     * @param array $data
     * @return array
     */
    public function transform($data)
    {
        return $data;
    }
}