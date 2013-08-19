<?php

namespace League\SemVer;

abstract class ParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return Parser
     */
    abstract function makeParser();

    function provideBadCases()
    {
        return [
            ['.'],
            ['..'],
            ['...'],
            [0],
            ['a'],
            ['a.b'],
            ['a.b.c'],
            ['1.0.0a'],
            'Missing minor' => ['0.'],
            'Missing . patch' => ['0.0'],
            'Missing patch' => ['0.0.'],
            'Extra trailing period' => ['0.0.0.'],
            'Extra .0 after version_core' => ['0.0.0.0'],
            'Empty pre-release' => ['0.0.0-'],
            'Empty build' => ['0.0.0+'],
            'Empty pre_release and build' => ['0.0.0-+'],
            'Leading 0 major' => ['01.0.0'],
            'Leading 0 minor' => ['0.01.0'],
            'Leading 0 patch' => ['0.0.01'],
            'Leading 0 pre-release' => ['1.0.0-rc.01'],
            'Empty dot-separated pre-release identifier' => ['1.0.0-rc.'],
            'Empty dot-separated build identifier' => ['1.0.0+rc.'],
        ];
    }

    /**
     * @dataProvider provideBadCases
     */
    function testBadCases($expr)
    {
        $parser = new RegexParser();
        $this->assertFalse($parser->isValidVersion($expr));

        $actual = $parser->parse($expr);
        $this->assertNull($actual);
    }

    function provideGoodCases()
    {
        return [
            '0.0.0' => ['0.0.0', new Version(0, 0, 0, [], [])],
            '1.0.0' => ['1.0.0', new Version(1, 0, 0, [], [])],
            '1.0.0--' => ['1.0.0--', new Version(1, 0, 0, ['-'], [])],
            '1.0.0-alpha' => ['1.0.0-alpha', new Version(1, 0, 0, ['alpha'], [])],
            '1.0.0-beta' => ['1.0.0-beta', new Version(1, 0, 0, ['beta'], [])],
            '1.0.0-10' => ['1.0.0-10', new Version(1, 0, 0, ['10'], [])],
            '1.0.0-alpha.beta' => ['1.0.0-alpha.beta', new Version(1, 0, 0, ['alpha','beta'], [])],
            '1.0.0-alpha.beta.gamma' => ['1.0.0-alpha.beta.gamma', new Version(1, 0, 0, ['alpha','beta','gamma'], [])],
            '1.0.0-beta.12' => ['1.0.0-beta.12', new Version(1, 0, 0, ['beta',12], [])],
            '1.0.0-rc' => ['1.0.0-rc', new Version(1, 0, 0, ['rc'], [])],
            '1.0.0-rc.1' => ['1.0.0-rc.1', new Version(1, 0, 0, ['rc',1], [])],
            '1.0.0-rc.12' => ['1.0.0-rc.12', new Version(1, 0, 0, ['rc',12], [])],
            '1.0.0+a' => ['1.0.0+a', new Version(1, 0, 0, [], ['a'])],
            '1.0.0+abc' => ['1.0.0+abc', new Version(1, 0, 0, [], ['abc'])],
            '1.0.0+abc.01' => ['1.0.0+abc.01', new Version(1, 0, 0, [], ['abc',1])],
            '1.0.0-alpha+abc' => ['1.0.0-alpha+abc', new Version(1, 0, 0, ['alpha'], ['abc'])],
            '1.0.0-alpha.1+a48bc.01' => ['1.0.0-alpha.1+a48bc.01', new Version(1, 0, 0, ['alpha',1], ['a48bc','01'])],

            '1.0.0-0a' => ['1.0.0-0a', new Version(1, 0, 0, ['0a'], [])],
        ];
    }

    /**
     * @dataProvider provideGoodCases
     */
    function testGoodCases($expr, Version $expected)
    {
        $parser = $this->makeParser();
        $this->assertTrue($parser->isValidVersion($expr));

        $actual = $parser->parse($expr);
        $this->assertEquals($expected, $actual);
    }

}