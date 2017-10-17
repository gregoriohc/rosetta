<?php

namespace Ghc\Rosetta;

use Ghc\Rosetta\Connectors\Connector;
use Ghc\Rosetta\Connectors\Request;
use Ghc\Rosetta\Exceptions\ManagerException;
use Ghc\Rosetta\Messages\Message;
use Ghc\Rosetta\Transformers\Transformer;

class Manager
{
    /**
     * @param string $class
     * @param array $config
     * @return Connector
     * @throws ManagerException
     */
    public static function connector($class, $config = [])
    {
        if (!str_contains($class, '\\')) {
            $class = '\\Ghc\\Rosetta\\Connectors\\' . studly_case($class);
        }

        if (!class_exists($class)) {
            throw new ManagerException("Connector class '$class' does not exists");
        }

        return new $class($config);
    }

    /**
     * @param Connector $connector
     * @param string $method
     * @param string $uri
     * @param mixed|null $data
     * @param array $options
     * @return Request
     */
    public static function connectorRequest(Connector $connector, $method, $uri, $data = null, $options = [])
    {
        return new Request($connector, $method, $uri, $data, $options);
    }

    /**
     * @param string $class
     * @param null|mixed $data
     * @param array $config
     * @return Message
     * @throws ManagerException
     */
    public static function message($class, $data = null, $config = [])
    {
        if (!str_contains($class, '\\')) {
            $class = '\\Ghc\\Rosetta\\Messages\\' . studly_case($class);
        }

        if (!class_exists($class)) {
            throw new ManagerException("Message class '$class' does not exists");
        }

        return new $class($data, $config);
    }

    /**
     * @param string $class
     * @param array $config
     * @return Message
     * @throws ManagerException
     */
    public static function transformer($class, $config = [])
    {
        if (!str_contains($class, '\\')) {
            $class = '\\Ghc\\Rosetta\\Transformers\\' . studly_case($class);
        }

        if (!class_exists($class)) {
            throw new ManagerException("Transformer class '$class' does not exists");
        }

        return new $class($config);
    }

    /**
     * @param array|mixed $data
     * @param Transformer|Transformer[] $transformers
     * @return Item
     */
    public static function item($data, $transformers = null)
    {
        return new Item($data, $transformers);
    }

    /**
     * @param array|mixed $data
     * @param Transformer|Transformer[] $transformers
     * @return Item
     */
    public static function collection($data, $transformers = null)
    {
        return new Collection($data, $transformers);
    }

    /**
     * @param string $class
     * @return
     * @throws ManagerException
     */
    public static function pipe($class)
    {
        if (!str_contains($class, '\\')) {
            $class = '\\Ghc\\Rosetta\\Pipes\\' . studly_case($class);
        }

        if (!class_exists($class)) {
            throw new ManagerException("Pipe class '$class' does not exists");
        }

        return new $class();
    }

    /**
     * @param string $class
     * @param null|mixed $data
     * @param array $config
     * @return
     * @throws ManagerException
     */
    public static function matcher($class, $data = null, $config = [])
    {
        if (!str_contains($class, '\\')) {
            $class = '\\Ghc\\Rosetta\\Matchers\\' . studly_case($class);
        }

        if (!class_exists($class)) {
            throw new ManagerException("Matcher class '$class' does not exists");
        }

        return new $class($data, $config);
    }

    /**
     * @param array $config
     * @return Pipeline
     */
    public static function pipeline($config = [])
    {
        return new Pipeline($config);
    }

    /**
     * @param Message $input
     * @param Message $output
     * @return Message
     */
    public static function transformMessage($input, $output)
    {
        return $output->fromArray($input->toArray());
    }
}
