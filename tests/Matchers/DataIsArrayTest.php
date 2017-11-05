<?php

namespace Tests\Ghc\Rosetta\Connectors;

use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Matchers\DataIsArray;
use PHPUnit\Framework\TestCase;

class DataIsArrayTest extends TestCase
{
    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            DataIsArray::class,
            Rosetta::matcher(DataIsArray::class)
        );
    }

    public function testCanMatch()
    {
        /** @var DataIsArray $matcher */
        $matcher = Rosetta::matcher(DataIsArray::class, []);

        $this->assertEquals(
            true,
            $matcher->match()
        );

        $matcher->setData('string');

        $this->assertEquals(
            false,
            $matcher->match()
        );
    }
}
