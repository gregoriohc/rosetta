<?php

namespace Ghc\Rosetta\Transformers;

class SlugizeKeys extends Transformer
{
    /**
     * @param array $data
     * @return array
     */
    public function transform($data)
    {
        return collect($data)->mapWithKeys(function($value, $key) {
            return [str_slug($key) => !is_array($value) ? $value : $this->transform($value)];
        })->toArray();
    }
}