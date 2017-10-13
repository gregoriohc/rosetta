<?php

namespace Tests\Ghc\Rosetta\Messages;

use Ghc\Rosetta\Manager;
use Ghc\Rosetta\Messages\HtmlElements;
use PHPUnit\Framework\TestCase;

class HtmlElementsTest extends TestCase
{
    public function testCanBeCreatedWithoutData()
    {
        $this->assertInstanceOf(
            HtmlElements::class,
            Manager::message('HtmlElements')
        );
    }

    public function testCanBeCreatedWithData()
    {
        $html = '<html><div></div></html>';
        $message = Manager::message('HtmlElements', $html);

        $this->assertInstanceOf(
            HtmlElements::class,
            $message
        );
    }

    public function testCanToArray()
    {
        $html = '<html><div class="foo">foo</div><div>bar</div></html>';
        $message = Manager::message('HtmlElements', $html, ['selector' => 'div']);

        $this->assertEquals(
            [
                [
                    '@attributes' => ['class' => 'foo'],
                    '_value' => 'foo'
                ],
                [
                    '@attributes' => [],
                    '_value' => 'bar'
                ]

            ],
            $message->toArray()
        );
    }
}
