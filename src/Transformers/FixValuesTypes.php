<?php

namespace Ghc\Rosetta\Transformers;

class FixValuesTypes extends Transformer
{
    /**
     * @param array $data
     * @return array
     */
    public function transform($data)
    {
        return collect($data)->map(function($value) {
            if (is_numeric($value)) {
                $value += 0;
                if (is_double($value)) {
                    return (double) $value;
                } elseif (is_float($value)) {
                    return (float) $value;
                } elseif (is_int($value)) {
                    return (int) $value;
                } elseif (is_bool($value)) {
                    return (bool) $value;
                }
            }

            return $value;
        })->toArray();
    }
}