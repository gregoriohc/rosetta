<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Messages\PhpArray;
use PHPUnit\Framework\TestCase;

class PhpArrayTest extends TestCase
{
    public function testCanBeCreatedWithoutData()
    {
        $this->assertInstanceOf(
            PhpArray::class,
            Rosetta::message('PhpArray')
        );
    }

    public function testCanBeCreatedWithData()
    {
        $array = ['foo' => 'bar'];
        $message = Rosetta::message('PhpArray', $array);

        $this->assertInstanceOf(
            PhpArray::class,
            $message
        );
    }

    public function testCanBeCreatedWithDataAndConfig()
    {
        $array = ['foo' => 'bar'];
        $config = ['foo' => 'bar'];
        $message = Rosetta::message('PhpArray', $array, $config);

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
        $message = Rosetta::message('PhpArray', $array);

        $this->assertEquals(
            $array,
            $message->toArray()
        );
    }

    public function testCanFromArray()
    {
        $array = ['foo' => 'bar'];
        $message = Rosetta::message('PhpArray', []);

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
        $message = Rosetta::message('PhpArray', $array);

        $this->assertEquals(
            serialize($array),
            (string) $message
        );
    }
}
