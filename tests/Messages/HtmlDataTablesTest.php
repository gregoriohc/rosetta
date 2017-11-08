<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Messages\HtmlDataTables;
use Ghc\Rosetta\Rosetta;
use PHPUnit\Framework\TestCase;

class HtmlDataTablesTest extends TestCase
{
    public function testCanBeCreatedWithoutData()
    {
        $this->assertInstanceOf(
            HtmlDataTables::class,
            Rosetta::message('HtmlDataTables')
        );
    }

    public function testCanBeCreatedWithData()
    {
        $html = '<html><table><tr><th>Foo</th><th>Bar</th></tr><tr><td>Woo</td><td>Car</td></tr><tr><td>Boo</td><td>Tar</td></tr></table></html>';
        $message = Rosetta::message('HtmlDataTables', $html);

        $this->assertInstanceOf(
            HtmlDataTables::class,
            $message
        );
    }

    public function testCanToArray()
    {
        $html = '<html><table><tr><th>Foo</th><th>Bar</th></tr><tr><td>Woo</td><td>Car</td></tr><tr><td>Boo</td><td>Tar</td></tr></table></html>';
        $message = Rosetta::message('HtmlDataTables', $html, []);

        $this->assertEquals(
            [
                [
                    [
                        'Foo' => 'Woo',
                        'Bar' => 'Car',
                    ],
                    [
                        'Foo' => 'Boo',
                        'Bar' => 'Tar',
                    ],
                ],

            ],
            $message->toArray()
        );
    }
}
