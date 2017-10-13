<?php

namespace Tests\Ghc\Rosetta;

use Ghc\Rosetta\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testToArray()
    {
        $data = [['foo' => 'bar'], ['bar' => 'foo']];
        $item = new Collection($data);

        $this->assertEquals(
            $data,
            $item->toArray()
        );
    }
}
