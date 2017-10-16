<?php

namespace Ghc\Rosetta\Matchers;

use Ghc\Rosetta\Configurable;
use Ghc\Rosetta\Pipes\Pipeable;
use Ghc\Rosetta\Pipeline;
use Illuminate\Support\Arr;

abstract class Matcher implements Pipeable
{
    use Configurable;

    /**
     * @var array
     */
    protected $data;

    /**
     * Matcher constructor.
     * @param $data
     * @param $config
     */
    public function __construct($data = null, $config = [])
    {
        $this->setData($data);
        $this->setConfig($config);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return boolean
     */
    abstract public function match();

    /**
     * @param \Closure $true
     * @param \Closure $false
     * @return mixed
     */
    public function matchAndRun($true, $false)
    {
        return $this->match() ? $true() : $false();
    }

    public function pipe($options = [])
    {
        return function($inputData) use ($options) {
            $true = Arr::get($options, 'true', new Pipeline());
            $true = $true instanceof \Closure ? $true() : $true;
            $false = Arr::get($options, 'false', new Pipeline());
            $false = $false instanceof \Closure ? $false() : $false;

            $this->setData($inputData);

            return $this->matchAndRun(
                function() use ($true, $inputData) {
                    /** @var Pipeline $true */
                    return $true->flow($inputData);
                },
                function() use ($false, $inputData) {
                    /** @var Pipeline $false */
                    return $false->flow($inputData);
                }
            );
        };
    }
}