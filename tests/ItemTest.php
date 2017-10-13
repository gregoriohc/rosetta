<?php

namespace Tests\Ghc\Rosetta;

use Ghc\Rosetta\Item;
use Ghc\Rosetta\Transformers\Skip;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testCanBeCreatedWithTransformer()
    {
        $this->assertInstanceOf(
            Item::class,
            new Item([], [new Skip])
        );
    }

    public function testCanBeCreatedWithoutTransformer()
    {
        $this->assertInstanceOf(
            Item::class,
            new Item([])
        );
    }

    public function testCanSetAndGetData()
    {
        $item = new Item([]);
        $data = ['foo' => 'bar'];
        $object = new \StdClass();

        // Using array
        $this->assertInstanceOf(
            Item::class,
            $item->setData($data)
        );

        $this->assertEquals(
            $data,
            $item->getData()
        );

        // Using non array
        $this->assertInstanceOf(
            Item::class,
            $item->setData($object)
        );

        $this->assertEquals(
            (array) $object,
            $item->getData()
        );
    }

    public function testCanSetAndGetTransformers()
    {
        $item = new Item([]);
        $transformer = new Skip;
        $transformers = [$transformer];

        // Using transformers array
        $this->assertInstanceOf(
            Item::class,
            $item->setTransformers($transformers)
        );

        $this->assertEquals(
            $transformers,
            $item->getTransformers()
        );

        // Using individual transformer
        $this->assertInstanceOf(
            Item::class,
            $item->setTransformers($transformer)
        );

        $this->assertEquals(
            $transformers,
            $item->getTransformers()
        );
    }

    public function testCanToArray()
    {
        $data = ['foo' => 'bar'];
        $item = new Item($data);

        $this->assertEquals(
            $data,
            $item->toArray()
        );
    }
}
