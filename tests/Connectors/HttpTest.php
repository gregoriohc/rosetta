<?php

namespace Tests\Ghc\Rosetta\Connectors;

use Ghc\Rosetta\Connectors\Http;
use Ghc\Rosetta\Rosetta;
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

        $this->http = Rosetta::connector(Http::class);
        $this->http->setClient($this->client);
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            Http::class,
            Rosetta::connector(Http::class)
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

    public function testCanBootClient()
    {
        /** @var Http $http */
        $http = Rosetta::connector(Http::class);

        $this->assertInstanceOf(
            Client::class,
            $http->getClient()
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

    public function testCanCreateWithData()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->create('http://example.com/post', ['foo' => 'bar'])
        );
    }

    public function testCanUpdate()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->update('http://example.com/patch')
        );
    }

    public function testCanUpdateWithData()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->update('http://example.com/patch', ['foo' => 'bar'])
        );
    }

    public function testCanReplace()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->replace('http://example.com/put')
        );
    }

    public function testCanReplaceWithData()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->replace('http://example.com/put', ['foo' => 'bar'])
        );
    }

    public function testCanDelete()
    {
        $this->assertInstanceOf(
            HttpResponse::class,
            $this->http->delete('http://example.com/delete')
        );
    }

    public function testCanSetAuthBasic()
    {
        /** @var Http $http */
        $http = Rosetta::connector(Http::class);

        $http->setAuth([
            'type' => Http::AUTH_BASIC,
            'username' => 'user',
            'password' => 'passwd'
        ]);

        $this->assertEquals(
            ['auth' => ['user', 'passwd']],
            $http->getConfig()
        );
    }

    public function testCanSetAuthDigest()
    {
        /** @var Http $http */
        $http = Rosetta::connector(Http::class);

        $http->setAuth([
            'type' => Http::AUTH_DIGEST,
            'username' => 'user',
            'password' => 'passwd'
        ]);

        $this->assertEquals(
            ['auth' => ['user', 'passwd', 'digest']],
            $http->getConfig()
        );
    }

    public function testCanSetAuthOauth1()
    {
        /** @var Http $http */
        $http = Rosetta::connector(Http::class);

        $http->setAuth([
            'type' => Http::AUTH_OAUTH1,
            'consumer_key' => 'key',
            'consumer_secret' => 'secret',
            'token' => 'accesskey',
            'token_secret' => 'accesssecret'
        ]);

        $this->assertArraySubset(
            ['auth' => 'oauth'],
            $http->getConfig()
        );
    }

    public function testCanSetAuthOauth2()
    {
        /** @var Http $http */
        $http = Rosetta::connector(Http::class);

        $http->setAuth([
            'type' => Http::AUTH_OAUTH2,
            'uri' => 'http://example.com/access_token',
            'grant_type' => 'password_credentials',
            'client_id' => 'id',
            'client_secret' => 'secret',
            'username' => 'user',
            'password' => 'passwd',
        ]);

        $this->assertArraySubset(
            ['auth' => 'oauth'],
            $http->getConfig()
        );
    }

    public function testCanSetAuthCookie()
    {
        /** @var Http $http */
        $http = Rosetta::connector(Http::class);

        $http->setAuth([
            'type' => Http::AUTH_COOKIE,
            'uri' => 'http://example.com/login',
            'fields' => [
                'username' => 'user',
                'password' => 'passwd',
            ],
        ]);

        $this->assertArraySubset(
            ['auth' => 'cookie'],
            $http->getConfig()
        );
    }

    public function testCanSetAuthCustom()
    {
        /** @var Http $http */
        $http = Rosetta::connector(Http::class);

        $http->setAuth([
            'type' => Http::AUTH_CUSTOM,
            'handler' => null,
            'auth' => 'test',
        ]);

        $this->assertArraySubset(
            ['handler' => null, 'auth' => 'test'],
            $http->getConfig()
        );
    }

    public function testCanSetAuthOnCreate()
    {
        $authConfig = [
            'type' => Http::AUTH_BASIC,
            'username' => 'user',
            'password' => 'passwd'
        ];

        /** @var Http $http */
        $http = Rosetta::connector(Http::class, ['auth_config' => $authConfig]);

        $http->getClient();

        $this->assertEquals(
            ['auth_config' => null, 'auth' => ['user', 'passwd']],
            $http->getConfig()
        );
    }
}
