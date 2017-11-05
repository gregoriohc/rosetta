<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Transformers\FixValuesTypes;
use PHPUnit\Framework\TestCase;

class FixValuesTypesTest extends TestCase
{
    /**
     * @var \Ghc\Rosetta\Transformers\Transformer
     */
    protected $transformer;

    public function setUp()
    {
        $this->transformer = Rosetta::transformer('FixValuesTypes');
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            FixValuesTypes::class,
            Rosetta::transformer('FixValuesTypes')
        );
    }

    public function testCanTransform()
    {
        $inputData = [
            'double'  => '1.23',
            'integer' => '1',
            'true'    => 'true',
            'false'   => 'false',
            'array'   => [],
            'foo'     => 'bar',
        ];
        $outputData = [
            'double'  => 1.23,
            'integer' => 1,
            'true'    => true,
            'false'   => false,
            'array'   => [],
            'foo'     => 'bar',
        ];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }
}
