<?php

namespace Ghc\Rosetta\Exceptions;

use Exception;

class ManagerException extends Exception
{
    /**
     * @param $class
     *
     * @return static
     */
    public static function undefinedConnector($class)
    {
        return new static("Connector class '$class' does not exists");
    }

    /**
     * @param $class
     *
     * @return static
     */
    public static function undefinedMessage($class)
    {
        return new static("Message class '$class' does not exists");
    }

    /**
     * @param $class
     *
     * @return static
     */
    public static function undefinedTransformer($class)
    {
        return new static("Transformer class '$class' does not exists");
    }

    /**
     * @param $class
     *
     * @return static
     */
    public static function undefinedPipe($class)
    {
        return new static("Pipe class '$class' does not exists");
    }

    /**
     * @param $class
     *
     * @return static
     */
    public static function undefinedMatcher($class)
    {
        return new static("Matcher class '$class' does not exists");
    }
}
