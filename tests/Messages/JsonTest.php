<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Messages\Json;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    public function testCanBeCreatedWithoutData()
    {
        $this->assertInstanceOf(
            Json::class,
            Manager::message('Json')
        );
    }

    public function testCanBeCreatedWithData()
    {
        $data = ['foo' => 'bar'];
        $json = json_encode($data);
        $message = Manager::message('Json', $json);

        $this->assertInstanceOf(
            Json::class,
            $message
        );
    }

    public function testCanBeCreatedWithDataAndConfig()
    {
        $data = ['foo' => 'bar'];
        $json = json_encode($data);
        $config = ['foo' => 'bar'];
        $message = Manager::message('Json', $json, $config);

        $this->assertInstanceOf(
            Json::class,
            $message
        );

        $this->assertEquals(
            $json,
            $message->getData()
        );

        $this->assertEquals(
            $config,
            $message->getConfig()
        );
    }

    public function testCanToArray()
    {
        $data = ['foo' => 'bar'];
        $json = json_encode($data);
        $message = Manager::message('Json', $json);

        $this->assertEquals(
            $data,
            $message->toArray()
        );
    }

    public function testCanFromArray()
    {
        $data = ['foo' => 'bar'];
        $message = Manager::message('Json');

        $this->assertInstanceOf(
            Json::class,
            $message->fromArray($data)
        );

        $this->assertEquals(
            $data,
            $message->toArray()
        );
    }

    public function testCanToString()
    {
        $data = ['foo' => 'bar'];
        $json = json_encode($data);
        $message = Manager::message('Json', $json);

        $this->assertEquals(
            $json,
            (string) $message
        );
    }
}
