<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Messages\PhpArray;
use PHPUnit\Framework\TestCase;

class PhpArrayTest extends TestCase
{
    public function testCanBeCreatedWithoutData()
    {
        $this->assertInstanceOf(
            PhpArray::class,
            Manager::message('PhpArray')
        );
    }

    public function testCanBeCreatedWithData()
    {
        $array = ['foo' => 'bar'];
        $message = Manager::message('PhpArray', $array);

        $this->assertInstanceOf(
            PhpArray::class,
            $message
        );
    }

    public function testCanBeCreatedWithDataAndConfig()
    {
        $array = ['foo' => 'bar'];
        $config = ['foo' => 'bar'];
        $message = Manager::message('PhpArray', $array, $config);

        $this->assertInstanceOf(
            PhpArray::class,
            $message
        );

        $this->assertEquals(
            $array,
            $message->getData()
        );

        $this->assertEquals(
            $config,
            $message->getConfig()
        );
    }

    public function testCanToArray()
    {
        $array = ['foo' => 'bar'];
        $message = Manager::message('PhpArray', $array);

        $this->assertEquals(
            $array,
            $message->toArray()
        );
    }

    public function testCanFromArray()
    {
        $array = ['foo' => 'bar'];
        $message = Manager::message('PhpArray', []);

        $this->assertInstanceOf(
            PhpArray::class,
            $message->fromArray($array)
        );

        $this->assertEquals(
            $array,
            $message->toArray()
        );
    }

    public function testCanToString()
    {
        $array = ['foo' => 'bar'];
        $message = Manager::message('PhpArray', $array);

        $this->assertEquals(
            serialize($array),
            (string) $message
        );
    }
}
