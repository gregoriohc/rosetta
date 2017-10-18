<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Transformers\DataTable;
use PHPUnit\Framework\TestCase;

class DataTableTest extends TestCase
{
    /**
     * @var \Ghc\Rosetta\Transformers\Transformer
     */
    protected $transformer;

    public function setUp()
    {
        $this->transformer = Manager::transformer('DataTable');
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            DataTable::class,
            Manager::transformer('DataTable')
        );
    }

    public function testCanTransform()
    {
        $inputData = [
            [
                'Header1',
                'Header2',
            ],
            [
                'Data1.1',
                'Data1.2',
            ],
            [
                'Data2.1',
                'Data2.2',
            ],
        ];
        $outputData = [
            [
                'Header1' => 'Data1.1',
                'Header2' => 'Data1.2',
            ],
            [
                'Header1' => 'Data2.1',
                'Header2' => 'Data2.2',
            ],
        ];

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }

    public function testCanTransformHorizontal()
    {
        $inputData = [
            [
                'Header1',
                'Data1.1',
                'Data2.1',
            ],
            [
                'Header2',
                'Data1.2',
                'Data2.2',
            ],
        ];
        $outputData = [
            [
                'Header1' => 'Data1.1',
                'Header2' => 'Data1.2',
            ],
            [
                'Header1' => 'Data2.1',
                'Header2' => 'Data2.2',
            ],
        ];

        $this->transformer->setConfig('orientation', 'horizontal');

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }

    public function testCanTransformWithoutHeader()
    {
        $inputData = [
            [
                'Data1.1',
                'Data1.2',
            ],
            [
                'Data2.1',
                'Data2.2',
            ],
        ];
        $outputData = [
            [
                'Data1.1',
                'Data1.2',
            ],
            [
                'Data2.1',
                'Data2.2',
            ],
        ];

        $this->transformer->setConfig('useHeaderAsIndex', false);

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }
}
