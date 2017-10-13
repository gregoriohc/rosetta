<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Messages\PhpObject;
use PHPUnit\Framework\TestCase;

class PhpObjectTest extends TestCase
{
    public function testCanBeCreatedWithoutData()
    {
        $this->assertInstanceOf(
            PhpObject::class,
            Manager::message('PhpObject')
        );
    }

    public function testCanBeCreatedWithData()
    {
        $object = new \StdClass();
        $message = Manager::message('PhpObject', $object);

        $this->assertInstanceOf(
            PhpObject::class,
            $message
        );
    }

    public function testCanBeCreatedWithDataAndConfig()
    {
        $object = new \StdClass();
        $config = ['foo' => 'bar'];
        $message = Manager::message('PhpObject', $object, $config);

        $this->assertInstanceOf(
            PhpObject::class,
            $message
        );

        $this->assertEquals(
            $object,
            $message->getData()
        );

        $this->assertEquals(
            $config,
            $message->getConfig()
        );
    }

    public function testCanToArray()
    {
        $object = new \StdClass();
        $object->foo = 'bar';
        $data = json_decode(json_encode($object), true);
        $message = Manager::message('PhpObject', $object);

        $this->assertEquals(
            $data,
            $message->toArray()
        );
    }

    public function testCanFromArray()
    {
        $object = new \StdClass();
        $object->foo = 'bar';
        $data = ['foo' => 'bar'];
        $message = Manager::message('PhpObject', $object);

        $this->assertInstanceOf(
            PhpObject::class,
            $message->fromArray($data)
        );

        $this->assertEquals(
            $data,
            $message->toArray()
        );
    }

    public function testCanToString()
    {
        $object = new \StdClass();
        $object->foo = 'bar';
        $data = json_decode(json_encode($object), true);
        $message = Manager::message('PhpObject', $object);

        $this->assertEquals(
            serialize($data),
            (string) $message
        );
    }
}
