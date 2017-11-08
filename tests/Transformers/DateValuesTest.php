<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Transformers\DateValues;
use PHPUnit\Framework\TestCase;

class DateValuesTest extends TestCase
{
    /**
     * @var \Ghc\Rosetta\Transformers\Transformer
     */
    protected $transformer;

    public function setUp()
    {
        $this->transformer = Rosetta::transformer('DateValues', [
            'locale'     => 'en_US',
            'timezone'   => 'UTC',
            'properties' => ['date'],
        ]);
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            DateValues::class,
            Rosetta::transformer('DateValues')
        );
    }

    public function testCanTransform()
    {
        $inputData = ['date' => '12/25/2017'];
        $outputData = ['date' => '2017-12-25T00:00:00+00:00'];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }

    public function testCannotTransformWrongValue()
    {
        $inputData = ['date' => 'wrong'];
        $outputData = ['date' => 'wrong'];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }
}
