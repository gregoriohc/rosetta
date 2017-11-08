<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Transformers\TransposeValues;
use PHPUnit\Framework\TestCase;

class TransposeValuesTest extends TestCase
{
    /**
     * @var \Ghc\Rosetta\Transformers\Transformer
     */
    protected $transformer;

    public function setUp()
    {
        $this->transformer = Rosetta::transformer('TransposeValues');
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            TransposeValues::class,
            Rosetta::transformer('TransposeValues')
        );
    }

    public function testCanTransform()
    {
        $inputData = [['value1.1', 'value1.2'], ['value2.1', 'value2.2']];
        $outputData = [['value1.1', 'value2.1'], ['value1.2', 'value2.2']];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }
}
