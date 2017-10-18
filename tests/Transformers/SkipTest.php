<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Transformers\Skip;
use PHPUnit\Framework\TestCase;

class SkipTest extends TestCase
{
    /**
     * @var \Ghc\Rosetta\Transformers\Transformer
     */
    protected $transformer;

    public function setUp()
    {
        $this->transformer = Manager::transformer('Skip');
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            Skip::class,
            Manager::transformer('Skip')
        );
    }

    public function testCanTransform()
    {
        $inputData = ['foo' => 'bar'];
        $outputData = ['foo' => 'bar'];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }
}
