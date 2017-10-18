<?php

namespace Ghc\Rosetta\Transformers;

class FixValuesTypes extends Transformer
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function transform($data)
    {
        return collect($data)->map(function ($value) {
            if (is_numeric($value)) {
                $value += 0;
                if (is_float($value)) {
                    return (float) $value;
                } elseif (is_int($value)) {
                    return (int) $value;
                }
            } elseif ('true' == $value) {
                return true;
            } elseif ('false' == $value) {
                return false;
            } elseif (is_array($value)) {
                return $this->transform($value);
            }

            return $value;
        })->toArray();
    }
}
