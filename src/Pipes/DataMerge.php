<?php

namespace Ghc\Rosetta\Pipes;

use Illuminate\Support\Arr;

class DataMerge implements Pipeable
{
    /**
     * @param array $options
     *
     * @return \Closure
     */
    public function pipe($options = [])
    {
        return function ($inputData) use ($options) {
            return array_merge($inputData, Arr::get($options, 'data'));
        };
    }
}
