<?php

namespace Tests\Ghc\Rosetta;

use Ghc\Rosetta\Collection;
use Ghc\Rosetta\Connectors\Request;
use Ghc\Rosetta\Exceptions\ManagerException;
use Ghc\Rosetta\Item;
use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Connectors\Http;
use Ghc\Rosetta\Matchers\DataIsArray;
use Ghc\Rosetta\Messages\Html;
use Ghc\Rosetta\Pipeline;
use Ghc\Rosetta\Pipes\DataGetKey;
use Ghc\Rosetta\Transformers\Skip;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    public function testCanCreateConnectorFromShortName()
    {
        $this->assertInstanceOf(
            Http::class,
            Manager::connector('Http')
        );
    }

    public function testCannotCreateConnectorFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Manager::connector('Wrong');
    }

    public function testCanCreateConnectorFromClassName()
    {
        $this->assertInstanceOf(
            Http::class,
            Manager::connector(Http::class)
        );
    }

    public function testCanCreateMessageFromShortName()
    {
        $this->assertInstanceOf(
            Html::class,
            Manager::message('Html')
        );
    }

    public function testCannotCreateMessageFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Manager::message('Wrong');
    }

    public function testCanCreateMessageFromClassName()
    {
        $this->assertInstanceOf(
            Html::class,
            Manager::message(Html::class)
        );
    }

    public function testCanCreateTransformerFromShortName()
    {
        $this->assertInstanceOf(
            Skip::class,
            Manager::transformer('Skip')
        );
    }

    public function testCannotCreateTransformerFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Manager::transformer('Wrong');
    }

    public function testCanCreateTransformerFromClassName()
    {
        $this->assertInstanceOf(
            Skip::class,
            Manager::transformer(Skip::class)
        );
    }

    public function testCanCreatePipeFromShortName()
    {
        $this->assertInstanceOf(
            DataGetKey::class,
            Manager::pipe('DataGetKey')
        );
    }

    public function testCannotCreatePipeFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Manager::pipe('Wrong');
    }

    public function testCanCreatePipeFromClassName()
    {
        $this->assertInstanceOf(
            DataGetKey::class,
            Manager::pipe(DataGetKey::class)
        );
    }

    public function testCanCreateMatcherFromShortName()
    {
        $this->assertInstanceOf(
            DataIsArray::class,
            Manager::matcher('DataIsArray')
        );
    }

    public function testCannotCreateMatcherFromInvalidShortName(): void
    {
        $this->expectException(ManagerException::class);

        Manager::matcher('Wrong');
    }

    public function testCanCreateMatcherFromClassName()
    {
        $this->assertInstanceOf(
            DataIsArray::class,
            Manager::matcher(DataIsArray::class)
        );
    }

    public function testCanTransformMessage()
    {
        $inputMessage = new Html();
        $outputMessage = new Html();

        Manager::transformMessage($inputMessage, $outputMessage);

        $this->assertEquals(
            $inputMessage->toArray(),
            $outputMessage->toArray()
        );
    }

    public function testCanCreateItem()
    {
        $this->assertInstanceOf(
            Item::class,
            Manager::item([])
        );
    }

    public function testCanCreateCollection()
    {
        $this->assertInstanceOf(
            Collection::class,
            Manager::collection([])
        );
    }

    public function testCanCreatePipeline()
    {
        $this->assertInstanceOf(
            Pipeline::class,
            Manager::pipeline([])
        );
    }

    public function testCanCreateConnectorRequest()
    {
        $this->assertInstanceOf(
            Request::class,
            Manager::connectorRequest(Manager::connector('Http'), 'show', 'http://example.com')
        );
    }
}
