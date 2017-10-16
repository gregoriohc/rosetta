<?php

namespace Ghc\Rosetta\Pipes;

use Illuminate\Support\Arr;

class DataGetKey implements Pipeable
{
    /**
     * @param array $options
     * @return \Closure
     */
    public function pipe($options = [])
    {
        return function ($inputData) use ($options) {
            return Arr::get($inputData, Arr::get($options, 'key'));
        };
    }
}
