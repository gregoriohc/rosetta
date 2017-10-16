<?php

namespace Tests\Ghc\Rosetta;

use Ghc\Rosetta\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testToArray()
    {
        $data = [['foo' => 'bar'], ['bar' => 'foo']];
        $collection = new Collection($data);

        $this->assertEquals(
            $data,
            $collection->toArray()
        );
    }
}
