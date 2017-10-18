<?php

namespace Ghc\Rosetta\Transformers;

use Ghc\Rosetta\Configurable;

abstract class Transformer
{
    use Configurable;

    /**
     * Connector constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->setConfig($config);

        $this->addDefaultConfig([
            'properties' => [],
        ]);

        $this->boot();
    }

    /**
     * Boot Transformer.
     */
    protected function boot()
    {
    }

    /**
     * @param array $data
     *
     * @return array
     */
    abstract public function transform($data);
}
