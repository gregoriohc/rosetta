<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Transformers\RemoveProperties;
use PHPUnit\Framework\TestCase;

class RemovePropertiesTest extends TestCase
{
    /**
     * @var \Ghc\Rosetta\Transformers\Transformer
     */
    protected $transformer;

    public function setUp()
    {
        $this->transformer = Rosetta::transformer('RemoveProperties', [
            'properties' => ['foo'],
        ]);
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            RemoveProperties::class,
            Rosetta::transformer('RemoveProperties')
        );
    }

    public function testCanTransform()
    {
        $inputData = ['foo' => 'bar', 'bar' => 'foo'];
        $outputData = ['bar' => 'foo'];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }
}
