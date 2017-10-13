<?php

namespace Tests\Ghc\Rosetta\Connectors;

use Ghc\Rosetta\Connectors\Http;
use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Messages\HttpResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
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
            Http::class,
            Manager::connector(Http::class)
        );
    }

    public function testCanSetClient()
    {
        $this->assertInstanceOf(
            Http::class,
            $this->http->setClient($this->client)
        );
    }

    public function testCanGetClient()
    {
        $this->assertInstanceOf(
            Client::class,
            $this->http->getClient()
        );
    }

    public function testCanShow()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->show('http://example.com/get')
        );
    }

    public function testCanCreate()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->create('http://example.com/post')
        );
    }

    public function testCanUpdate()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->update('http://example.com/patch')
        );
    }

    public function testCanReplace()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->replace('http://example.com/put')
        );
    }

    public function testCanDelete()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->delete('http://example.com/delete')
        );
    }
}
