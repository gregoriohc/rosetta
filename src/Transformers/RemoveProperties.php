<?php

namespace Ghc\Rosetta\Transformers;

class RemoveProperties extends Transformer
{
    /**
     * @param array $data
     * @return array
     */
    public function transform($data)
    {
        return collect($data)->reject(function($value, $key) {
            return in_array($key, $this->config['properties']);
        })->map(function($value) {
            return !is_array($value) ? $value : $this->transform($value);
        })->toArray();
    }
}