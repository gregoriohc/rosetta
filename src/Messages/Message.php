<?php

namespace Ghc\Rosetta\Messages;

use Illuminate\Contracts\Support\Arrayable;

abstract class Message implements Arrayable
{
    /**
     * Configuration options
     *
     * @var mixed
     */
    protected $data;

    /**
     * Configuration options
     *
     * @var array
     */
    protected $config;

    /**
     * Connector constructor.
     * @param null|mixed $data
     * @param array $config
     */
    public function __construct($data = null, $config = [])
    {
        $this->data = $data ?: $this->new();
        $this->config = $config;
    }

    /**
     * @return null
     */
    public function new()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return self
     */
    public function set($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array $data
     * @return self
     */
    abstract public function fromArray($data);
}