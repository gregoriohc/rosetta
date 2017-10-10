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
     * @return string
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->fromArray(unserialize($serialized));
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
        return (string) $this->data;
    }

    /**
     * @param array $data
     * @return self
     */
    abstract public function fromArray($data);

}