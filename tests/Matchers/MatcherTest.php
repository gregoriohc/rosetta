<?php

namespace Tests\Ghc\Rosetta\Connectors;

use Ghc\Rosetta\Rosetta;
use Ghc\Rosetta\Matchers\Matcher;
use PHPUnit\Framework\TestCase;

class MatcherTest extends TestCase
{
    public function testCanBeCreated()
    {
        $this->assertInstanceOf(
            Matcher::class,
            Rosetta::matcher(TestMatcher::class)
        );
    }

    public function testCanGetData()
    {
        /** @var Matcher $matcher */
        $matcher = Rosetta::matcher(TestMatcher::class, []);

        $this->assertEquals(
            [],
            $matcher->getData()
        );
    }

    public function testCanMatch()
    {
        /** @var Matcher $matcher */
        $matcher = Rosetta::matcher(TestMatcher::class, true);

        $this->assertEquals(
            true,
            $matcher->match()
        );
    }

    public function testCanMatchAndRun()
    {
        /** @var Matcher $matcher */
        $matcher = Rosetta::matcher(TestMatcher::class, true);

        $this->assertEquals(
            'foo',
            $matcher->matchAndRun(function () {
                return 'foo';
            }, function () {
                return 'bar';
            })
        );

        $matcher->setData(false);

        $this->assertEquals(
            'bar',
            $matcher->matchAndRun(function () {
                return 'foo';
            }, function () {
                return 'bar';
            })
        );
    }
}

class TestMatcher extends Matcher
{
    /**
     * @return bool
     */
    public function match()
    {
        return (bool) $this->getData();
    }
}
