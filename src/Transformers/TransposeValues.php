<?php

namespace Ghc\Rosetta\Transformers;

class TransposeValues extends Transformer
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function transform($data)
    {
        return array_map(null, ...$data);
    }
}
