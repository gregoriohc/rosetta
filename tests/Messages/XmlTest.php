<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Messages\Xml;
use PHPUnit\Framework\TestCase;

class XmlTest extends TestCase
{
    public function testCanBeCreatedWithoutData()
    {
        $this->assertInstanceOf(
            Xml::class,
            Manager::message('Xml')
        );
    }

    public function testCanBeCreatedWithData()
    {
        $xml = '<xml><element></element></xml>';
        $message = Manager::message('Xml', $xml);

        $this->assertInstanceOf(
            Xml::class,
            $message
        );
    }

    public function testCanToArray()
    {
        $xml = '<xml><element foo="bar">foo</element><element>bar</element></xml>';
        $message = Manager::message('Xml', $xml);

        $this->assertEquals(
            [
                '@attributes' => [],
                'xml'         => [
                    '@attributes' => [],
                    'element'     => [
                        [
                            '@attributes' => ['foo' => 'bar'],
                            '_value'      => 'foo',
                        ],
                        [
                            '@attributes' => [],
                            '_value'      => 'bar',
                        ],
                    ],
                ],

            ],
            $message->toArray()
        );
    }
}
