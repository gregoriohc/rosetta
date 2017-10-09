<?php

namespace Ghc\Rosetta;

use Ghc\Rosetta\Connectors\Connector;
use Ghc\Rosetta\Messages\Message;

class Manager
{
    /**
     * @param string $name
     * @param array $config
     * @return Connector
     */
    public static function connector($name, $config = [])
    {
        $name = '\\Ghc\\Rosetta\\Connectors\\' . camel_case($name);

        return new $name($config);
    }

    /**
     * @param string $type
     * @param null|mixed $data
     * @param array $config
     * @return Message
     */
    public static function message($type, $data = null, $config = [])
    {
        $name = '\\Ghc\\Rosetta\\Messages\\' . camel_case($type);

        return new $name($data, $config);
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
