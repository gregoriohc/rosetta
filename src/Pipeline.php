<?php

namespace Ghc\Rosetta;

use Ghc\Rosetta\Pipes\Pipeable;

class Pipeline
{
    use Configurable;

    /**
     * @var \Closure[]
     */
    protected $pipes = [];

    /**
     * Pipeline constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->setConfig($config);
    }

    public function pushPipe($pipe, $options = [])
    {
        if ($pipe instanceof Pipeable) {
            $this->pipes[] = $pipe->pipe($options);
        } elseif ($pipe instanceof \Closure) {
            $this->pipes[] = $pipe;
        }

        return $this;
    }

    public function flow($data = null)
    {
        foreach ($this->pipes as $pipe) {
            /** @var \Closure $pipe */
            $data = $pipe($data);
        }

        return $data;
    }
}
