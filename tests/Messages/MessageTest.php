<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Messages\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testCanBeCreated()
    {
        $message = new TestMessage();

        $this->assertInstanceOf(
            TestMessage::class,
            $message
        );
    }

    public function testCanBeSerialized()
    {
        $message = new TestMessage();

        $this->assertEquals(
            $message,
            unserialize(serialize($message))
        );
    }

    public function testCanBeJsonSerialized()
    {
        $message = new TestMessage();

        $this->assertEquals(
            json_encode([]),
            json_encode($message)
        );
    }
}

class TestMessage extends Message
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [];
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public function fromArray($data)
    {
        return $this;
    }
}
