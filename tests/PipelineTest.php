<?php

namespace Tests\Ghc\Rosetta;

use Ghc\Rosetta\Collection;
use Ghc\Rosetta\Connectors\Http;
use Ghc\Rosetta\Connectors\Request;
use Ghc\Rosetta\Item;
use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Messages\HttpResponse;
use Ghc\Rosetta\Pipeline;
use Ghc\Rosetta\Pipes\DataGetKey;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class PipelineTest extends TestCase
{
    public function testCanBeCreatedWithConfig()
    {
        $this->assertInstanceOf(
            Pipeline::class,
            new Pipeline([])
        );
    }

    public function testCanBeCreatedWithoutConfig()
    {
        $this->assertInstanceOf(
            Pipeline::class,
            new Pipeline()
        );
    }

    public function testCanPushPipeOfClosureType()
    {
        $this->assertInstanceOf(
            Pipeline::class,
            (new Pipeline())->pushPipe(function() {})
        );
    }

    public function testCanPushPipeOfPipeableType()
    {
        $this->assertInstanceOf(
            Pipeline::class,
            (new Pipeline())->pushPipe(new DataGetKey())
        );
    }

    public function testCanPushPipeItem()
    {
        $this->assertInstanceOf(
            Pipeline::class,
            (new Pipeline())->pushPipe(new Item())
        );
    }

    public function testCanFlow()
    {
        $pipeline = new Pipeline();
        $pipeline->pushPipe(new DataGetKey(), ['key' => 'foo']);
        $pipeline->pushPipe(function($inputData) {
            $inputData['bar'] = 456;
            return $inputData;
        });

        $this->assertEquals(
            ['bar' => 456],
            $pipeline->flow(['foo' => ['bar' => 123]])
        );
    }

    public function testCanFlowWithItem()
    {
        $pipeline = new Pipeline();
        $pipeline->pushPipe(new Item([]));

        $this->assertEquals(
            [],
            $pipeline->flow([])
        );
    }

    public function testCanFlowWithCollection()
    {
        $pipeline = new Pipeline();
        $pipeline->pushPipe(new Collection([]));

        $this->assertEquals(
            [],
            $pipeline->flow([])
        );
    }

    public function testCanFlowWithRequest()
    {
        $mock = new MockHandler([new Response(200, ['X-Foo' => 'Bar'])]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        /** @var Http $http */
        $http = Manager::connector(Http::class);
        $http->setClient($client);
        $pipeline = new Pipeline();
        $pipeline->pushPipe(new Request($http, 'show', 'http://example.com'));

        $this->assertEquals(
            '',
            (string) $pipeline->flow(['foo' => 'bar'])['body']
        );
    }
}
