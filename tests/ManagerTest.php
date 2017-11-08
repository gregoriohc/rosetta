<?php

namespace Tests\Ghc\Rosetta;

use Ghc\Rosetta\Collection;
use Ghc\Rosetta\Connectors\Http;
use Ghc\Rosetta\Connectors\Request;
use Ghc\Rosetta\Exceptions\ManagerException;
use Ghc\Rosetta\Item;
use Ghc\Rosetta\Matchers\DataIsArray;
use Ghc\Rosetta\Messages\Html;
use Ghc\Rosetta\Pipeline;
use Ghc\Rosetta\Pipes\DataGetKey;
use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Transformers\Skip;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    public function testCanCreateConnectorFromShortName()
    {
        $this->assertInstanceOf(
            Http::class,
            Rosetta::connector('Http')
        );
    }

    public function testCannotCreateConnectorFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Rosetta::connector('Wrong');
    }

    public function testCanCreateConnectorFromClassName()
    {
        $this->assertInstanceOf(
            Http::class,
            Rosetta::connector(Http::class)
        );
    }

    public function testCanCreateMessageFromShortName()
    {
        $this->assertInstanceOf(
            Html::class,
            Rosetta::message('Html')
        );
    }

    public function testCannotCreateMessageFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Rosetta::message('Wrong');
    }

    public function testCanCreateMessageFromClassName()
    {
        $this->assertInstanceOf(
            Html::class,
            Rosetta::message(Html::class)
        );
    }

    public function testCanCreateTransformerFromShortName()
    {
        $this->assertInstanceOf(
            Skip::class,
            Rosetta::transformer('Skip')
        );
    }

    public function testCannotCreateTransformerFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Rosetta::transformer('Wrong');
    }

    public function testCanCreateTransformerFromClassName()
    {
        $this->assertInstanceOf(
            Skip::class,
            Rosetta::transformer(Skip::class)
        );
    }

    public function testCanCreatePipeFromShortName()
    {
        $this->assertInstanceOf(
            DataGetKey::class,
            Rosetta::pipe('DataGetKey')
        );
    }

    public function testCannotCreatePipeFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Rosetta::pipe('Wrong');
    }

    public function testCanCreatePipeFromClassName()
    {
        $this->assertInstanceOf(
            DataGetKey::class,
            Rosetta::pipe(DataGetKey::class)
        );
    }

    public function testCanCreateMatcherFromShortName()
    {
        $this->assertInstanceOf(
            DataIsArray::class,
            Rosetta::matcher('DataIsArray')
        );
    }

    public function testCannotCreateMatcherFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Rosetta::matcher('Wrong');
    }

    public function testCanCreateMatcherFromClassName()
    {
        $this->assertInstanceOf(
            DataIsArray::class,
            Rosetta::matcher(DataIsArray::class)
        );
    }

    public function testCanTransformMessage()
    {
        $inputMessage = new Html();
        $outputMessage = new Html();

        Rosetta::transformMessage($inputMessage, $outputMessage);

        $this->assertEquals(
            $inputMessage->toArray(),
            $outputMessage->toArray()
        );
    }

    public function testCanCreateItem()
    {
        $this->assertInstanceOf(
            Item::class,
            Rosetta::item([])
        );
    }

    public function testCanCreateCollection()
    {
        $this->assertInstanceOf(
            Collection::class,
            Rosetta::collection([])
        );
    }

    public function testCanCreatePipeline()
    {
        $this->assertInstanceOf(
            Pipeline::class,
            Rosetta::pipeline([])
        );
    }

    public function testCanCreateConnectorRequest()
    {
        $this->assertInstanceOf(
            Request::class,
            Rosetta::connectorRequest(Rosetta::connector('Http'), 'show', 'http://example.com')
        );
    }
}
