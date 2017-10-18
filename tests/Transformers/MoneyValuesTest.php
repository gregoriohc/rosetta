<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Transformers\MoneyValues;
use PHPUnit\Framework\TestCase;

class MoneyValuesTest extends TestCase
{
    /**
     * @var \Ghc\Rosetta\Transformers\Transformer
     */
    protected $transformer;

    public function setUp()
    {
        $this->transformer = Manager::transformer('MoneyValues', [
            'locale' => 'en_US',
            'currency_code' => 'USD',
            'properties' => ['dollars'],
        ]);
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            MoneyValues::class,
            Manager::transformer('MoneyValues')
        );
    }

    public function testCanTransform()
    {
        $inputData = ['dollars' => '$123.45 USD'];
        $outputData = ['dollars' => ['amount' => 12345, 'currency' => 'USD']];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }

    public function testCannotTransformWrongValue()
    {
        $inputData = ['dollars' => 'wrong'];
        $outputData = ['dollars' => 'wrong'];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }
}
