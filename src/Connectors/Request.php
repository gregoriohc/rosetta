<?php

namespace Ghc\Rosetta\Connectors;

use Ghc\Rosetta\Messages\Message;
use Ghc\Rosetta\Pipes\Pipeable;

class Request implements Pipeable
{
    const SHOW = 'show';
    const CREATE = 'create';
    const UPDATE = 'update';
    const REPLACE = 'replace';
    const DELETE = 'delete';

    /**
     * @var Connector
     */
    protected $connector;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var array
     */
    protected $options;

    /**
     * Request constructor.
     * @param Connector $connector
     * @param string $method
     * @param string $uri
     * @param mixed $data
     * @param array $options
     */
    public function __construct(Connector $connector, $method, $uri, $data = null, $options = [])
    {
        $this->setConnector($connector);
        $this->setMethod($method);
        $this->setUri($uri);
        $this->setData($data);
        $this->setOptions($options);
    }

    /**
     * @return Connector
     */
    public function getConnector()
    {
        return $this->connector;
    }

    /**
     * @param Connector $connector
     * @return Request
     */
    public function setConnector($connector)
    {
        $this->connector = $connector;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Request
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return Request
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
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
     * @return Request
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return Request
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        switch ($this->getMethod()) {
            case self::SHOW:
            case self::DELETE:
                return call_user_func_array([
                    $this->getConnector(),
                    $this->getMethod(),
                ], [
                    $this->getUri(),
                    $this->getOptions(),
                ]);
            default:
                return call_user_func_array([
                    $this->getConnector(),
                    $this->getMethod(),
                ], [
                    $this->getUri(),
                    $this->getData(),
                    $this->getOptions(),
                ]);
        }
    }

    /**
     * @param array $options
     * @return \Closure
     */
    public function pipe($options = [])
    {
        return function($inputData) use ($options) {
            if (!is_null($inputData)) {
                $this->setData($inputData);
            }

            /** @var Message $message */
            $message = $this->handle();

            return $message->toArray();
        };
    }
}