<?php

namespace Ghc\Rosetta\Matchers;

class DataIsArray extends Matcher
{
    /**
     * @return bool
     */
    public function match()
    {
        return is_array($this->getData());
    }
}
