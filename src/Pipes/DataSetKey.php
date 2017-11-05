<?php

namespace Ghc\Rosetta\Pipes;

use Illuminate\Support\Arr;

class DataSetKey implements Pipeable
{
    /**
     * @param array $options
     *
     * @return \Closure
     */
    public function pipe($options = [])
    {
        return function ($inputData) use ($options) {
            return Arr::set($inputData, Arr::get($options, 'key'), Arr::get($options, 'value'));
        };
    }
}
