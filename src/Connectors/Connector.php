<?php

namespace Ghc\Rosetta\Connectors;

abstract class Connector
{
    /**
     * Configuration options
     *
     * @var array
     */
    protected $config;

    /**
     * Connector constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;

        $this->boot();
    }

    /**
     */
    abstract public function boot();

    /**
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    abstract public function show($uri, $options = []);

    /**
     * @param string $uri
     * @param null|mixed $data
     * @param array $options
     * @return mixed
     */
    abstract public function create($uri, $data = null, $options = []);

    /**
     * @param string $uri
     * @param null|mixed $data
     * @param array $options
     * @return mixed
     */
    abstract public function update($uri, $data = null, $options = []);

    /**
     * @param string $uri
     * @param null|mixed $data
     * @param array $options
     * @return mixed
     */
    abstract public function replace($uri, $data = null, $options = []);

    /**
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    abstract public function delete($uri, $options = []);
}