<?php

namespace Ghc\Rosetta;

use Ghc\Rosetta\Connectors\Connector;
use Ghc\Rosetta\Exceptions\ManagerException;
use Ghc\Rosetta\Messages\Message;

class Manager
{
    /**
     * @param string $class
     * @param array $config
     * @return Connector
     * @throws \Exception
     */
    public static function connector($class, $config = [])
    {
        if (!str_contains($class, '\\')) {
            $class = '\\Ghc\\Rosetta\\Connectors\\' . camel_case($class);
        }

        if (!class_exists($class)) {
            throw new ManagerException("Connector class '$class' does not exists");
        }

        return new $class($config);
    }

    /**
     * @param string $class
     * @param null|mixed $data
     * @param array $config
     * @return Message
     * @throws \Exception
     */
    public static function message($class, $data = null, $config = [])
    {
        if (!str_contains($class, '\\')) {
            $class = '\\Ghc\\Rosetta\\Messages\\' . camel_case($class);
        }

        if (!class_exists($class)) {
            throw new ManagerException("Message class '$class' does not exists");
        }

        return new $class($data, $config);
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
