<?php

namespace Ghc\Rosetta\Transformers;

class Skip extends Transformer
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function transform($data)
    {
        return $data;
    }
}
