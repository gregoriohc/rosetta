<?php

namespace Tests\Ghc\Rosetta\Connectors;

use Ghc\Rosetta\Connectors\Http;
use Ghc\Rosetta\Connectors\Request;
use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Messages\HttpResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /** @var Client */
    protected $client;
    /** @var Http */
    protected $http;

    protected function setUp()
    {
        $mock = new MockHandler([new Response(200, ['X-Foo' => 'Bar'])]);
        $handler = HandlerStack::create($mock);

        $this->client = new Client(['handler' => $handler]);

        $this->http = Manager::connector(Http::class);
        $this->http->setClient($this->client);
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            Request::class,
            Manager::connectorRequest($this->http, 'show', 'http://example.com')
        );
    }

    public function testCanGetConnector()
    {
        $request = Manager::connectorRequest($this->http, 'show', 'http://example.com');

        $this->assertInstanceOf(
            Http::class,
            $request->getConnector()
        );
    }

    public function testCanGetMethod()
    {
        $request = Manager::connectorRequest($this->http, 'show', 'http://example.com');

        $this->assertEquals(
            'show',
            $request->getMethod()
        );
    }

    public function testCanGetUri()
    {
        $request = Manager::connectorRequest($this->http, 'show', 'http://example.com');

        $this->assertEquals(
            'http://example.com',
            $request->getUri()
        );
    }

    public function testCanGetData()
    {
        $data = ['foo' => 'bar'];
        $request = Manager::connectorRequest($this->http, 'create', 'http://example.com', $data);

        $this->assertEquals(
            $data,
            $request->getData()
        );
    }

    public function testCanGetOptions()
    {
        $options = ['foo' => 'bar'];
        $request = Manager::connectorRequest($this->http, 'create', 'http://example.com', [], $options);

        $this->assertEquals(
            $options,
            $request->getOptions()
        );
    }

    public function testCanHandleShow()
    {
        $request = Manager::connectorRequest($this->http, 'show', 'http://example.com');

        $this->assertInstanceOf(
            HttpResponse::class,
            $request->handle()
        );
    }

    public function testCanHandleCreate()
    {
        $data = ['foo' => 'bar'];
        $request = Manager::connectorRequest($this->http, 'create', 'http://example.com', $data);

        $this->assertInstanceOf(
            HttpResponse::class,
            $request->handle()
        );
    }
}
