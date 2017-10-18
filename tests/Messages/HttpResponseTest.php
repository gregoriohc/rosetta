<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Messages\HttpResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class HttpResponseTest extends TestCase
{
    public function testCanBeCreatedWithoutData()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            Manager::message('HttpResponse')
        );
    }

    public function testCanBeCreatedWithData()
    {
        $httpResponse = new Response();
        $message = Manager::message('HttpResponse', $httpResponse);

        $this->assertInstanceOf(
            HttpResponse::class,
            $message
        );
    }

    public function testCanBeCreatedWithDataAndConfig()
    {
        $httpResponse = new Response();
        $config = ['foo' => 'bar'];
        $message = Manager::message('HttpResponse', $httpResponse, $config);

        $this->assertInstanceOf(
            HttpResponse::class,
            $message
        );

        $this->assertEquals(
            $httpResponse,
            $message->getData()
        );

        $this->assertEquals(
            $config,
            $message->getConfig()
        );
    }

    public function testCanToArray()
    {
        $httpResponse = new Response(200, ['foo' => 'bar'], 'response');
        $data = [
            'status_code' => $httpResponse->getStatusCode(),
            'headers'     => $httpResponse->getHeaders(),
            'body'        => (string) $httpResponse->getBody(),
        ];
        $message = Manager::message('HttpResponse', $httpResponse);

        $this->assertEquals(
            $data,
            $message->toArray()
        );
    }

    public function testCanFromArray()
    {
        $data = [
            'status_code' => 200,
            'headers'     => [],
            'body'        => 'response',
        ];
        $message = Manager::message('HttpResponse');

        $this->assertInstanceOf(
            HttpResponse::class,
            $message->fromArray($data)
        );

        $this->assertEquals(
            $data,
            $message->toArray()
        );
    }

    public function testCanToString()
    {
        $httpResponse = new Response();
        $message = Manager::message('HttpResponse', $httpResponse);

        $this->assertEquals(
            '',
            (string) $message
        );
    }
}
