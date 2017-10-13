<?php

namespace Ghc\Rosetta\Messages;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Serializable;

abstract class Message implements Arrayable, Serializable, JsonSerializable
{
    /**
     * Message data
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
     * Message constructor.
     * @param null|mixed $data
     * @param array $config
     */
    public function __construct($data = null, $config = [])
    {
        $this->setData($data ?: $this->newData());
        $this->setConfig($config);

        $this->boot();
    }

    /**
     * Boot Transformer
     */
    protected function boot()
    {
    }

    /**
     * @return null
     */
    public function newData()
    {
        return null;
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
     * @param array $config
     * @return Message
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
            'data' => $this->toArray(),
            'config' => $this->getConfig(),
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $unserialized = unserialize($serialized);
        $this->fromArray($unserialized['data']);
        $this->setConfig($unserialized['config']);
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getData();
    }

    /**
     * @param array $config
     */
    protected function addDefaultConfig($config)
    {
        $this->setConfig(array_merge($config, $this->getConfig()));
    }

    /**
     * @param array $data
     * @return self
     */
    abstract public function fromArray($data);

}