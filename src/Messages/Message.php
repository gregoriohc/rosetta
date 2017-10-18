<?php

namespace Ghc\Rosetta\Messages;

use Ghc\Rosetta\Configurable;
use Ghc\Rosetta\Pipes\Pipeable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use JsonSerializable;
use Serializable;

abstract class Message implements Arrayable, Serializable, JsonSerializable, Pipeable
{
    use Configurable;

    /**
     * Message data.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Message constructor.
     *
     * @param null|mixed $data
     * @param array      $config
     */
    public function __construct($data = null, $config = [])
    {
        $this->setData($data ?: $this->newData());
        $this->setConfig($config);

        $this->boot();
    }

    /**
     * Boot Transformer.
     */
    protected function boot()
    {
    }

    /**
     * @return null
     */
    public function newData()
    {
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
     *
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
            'data'   => $this->toArray(),
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
    public function jsonSerialize()
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
     * @param array $options
     *
     * @return \Closure
     */
    public function pipe($options = [])
    {
        return function ($inputData) use ($options) {
            $fromArray = Arr::get($options, 'fromArray', true);
            if ($fromArray) {
                $this->fromArray($inputData);
            } else {
                $this->setData($inputData);
            }

            return $this->toArray();
        };
    }

    /**
     * @param array $data
     *
     * @return self
     */
    abstract public function fromArray($data);
}
