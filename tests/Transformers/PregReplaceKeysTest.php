<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Transformers\PregReplaceKeys;
use PHPUnit\Framework\TestCase;

class PregReplaceKeysTest extends TestCase
{
    /**
     * @var \Ghc\Rosetta\Transformers\Transformer
     */
    protected $transformer;

    public function setUp()
    {
        $this->transformer = Rosetta::transformer('PregReplaceKeys');
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            PregReplaceKeys::class,
            Rosetta::transformer('PregReplaceKeys')
        );
    }

    public function testCanTransform()
    {
        $inputData = ['foo' => 'bar'];
        $outputData = ['woo' => 'bar'];

        $this->transformer->setConfig([
            'pattern'     => '/foo/',
            'replacement' => 'woo',
        ]);

        $this->assertEquals(
            $outputData,
            $this->transformer->transform($inputData)
        );
    }
}
