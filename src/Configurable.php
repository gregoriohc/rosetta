<?php

namespace Ghc\Rosetta;

use Illuminate\Config\Repository;

trait Configurable
{
    /**
     * Configuration options
     *
     * @var Repository
     */
    protected $config;

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config->all();
    }

    /**
     * @param array $config
     * @return self
     */
    public function setConfig($config)
    {
        $this->config = new Repository($config);

        return $this;
    }

    /**
     * @param array $config
     */
    protected function addDefaultConfig($config)
    {
        $this->setConfig(array_merge($config, $this->getConfig()));
    }
}
