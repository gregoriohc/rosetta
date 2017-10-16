<?php

namespace Ghc\Rosetta\Pipes;

interface Pipeable
{
    /**
     * @param array $options
     * @return \Closure
     */
    public function pipe($options = []);
}
