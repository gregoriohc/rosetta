<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Transformers\SlugizeKeys;
use PHPUnit\Framework\TestCase;

class SlugizeKeysTest extends TestCase
{
    /**
     * @var \Ghc\Rosetta\Transformers\Transformer
     */
    protected $transformer;

    public function setUp()
    {
        $this->transformer = Rosetta::transformer('SlugizeKeys');
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            SlugizeKeys::class,
            Rosetta::transformer('SlugizeKeys')
        );
    }

    public function testCanTransform()
    {
        $inputData = ['Foo Bar' => 'bar'];
        $outputData = ['foo_bar' => 'bar'];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }

    public function testCanTransformWithConfig()
    {
        $inputData = ['Foo Bar' => 'bar'];
        $outputData = ['foo-bar' => 'bar'];

        $this->transformer->setConfig(['separator' => '-']);

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }
}
