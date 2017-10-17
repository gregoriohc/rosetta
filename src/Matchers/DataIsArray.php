<?php

namespace Ghc\Rosetta\Matchers;

class DataIsArray extends Matcher
{
    /**
     * @return boolean
     */
    public function match()
    {
        return is_array($this->getData());
    }
}