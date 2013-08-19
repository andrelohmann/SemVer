<?php

require_once __DIR__ . '/../../RegexParser.php';

class RegexParserTest extends \PHPUnit_Framework_TestCase {

    function provideBadCases() {
        return [
            ['.'],
            ['..'],
            ['...'],
            ['0'],
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
            'Empt dot-separated pre-release identifier' => ['1.0.0-rc.'],
        ];
    }

    /**
     * @dataProvider provideBadCases
     */
    function testBadCases($expr) {
        $parser = new RegexParser();
        $actual = $parser->parse($expr);
        $this->assertFalse($actual);
    }

    function provideGoodCases() {
        return [
            '0.0.0' => ['0.0.0', ['major' => '0', 'minor' => '0', 'patch' => '0']],
            '1.0.0' => ['1.0.0', ['major' => '1', 'minor' => '0', 'patch' => '0']],
            '1.0.0--' => ['1.0.0--', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => '-']],
            '1.0.0-alpha' => ['1.0.0-alpha', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => 'alpha']],
            '1.0.0-beta' => ['1.0.0-beta', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => 'beta']],
            '1.0.0-10' => ['1.0.0-10', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => '10']],
            '1.0.0-alpha.beta' => ['1.0.0-alpha.beta', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => 'alpha.beta']],
            '1.0.0-alpha.beta.gamma' => ['1.0.0-alpha.beta.gamma', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => 'alpha.beta.gamma']],
            '1.0.0-beta.12' => ['1.0.0-beta.12', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => 'beta.12']],
            '1.0.0-rc' => ['1.0.0-rc', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => 'rc']],
            '1.0.0-rc.1' => ['1.0.0-rc.1', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => 'rc.1']],
            '1.0.0-rc.12' => ['1.0.0-rc.12', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => 'rc.12']],
            '1.0.0+a' => ['1.0.0+a', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => '', 'build' => 'a']],
            '1.0.0+abc' => ['1.0.0+abc', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => '', 'build' => 'abc']],
            '1.0.0+abc.01' => ['1.0.0+abc.01', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => '', 'build' => 'abc.01']],
            '1.0.0-alpha+abc' => ['1.0.0-alpha+abc', ['major' => '1', 'minor' => '0', 'patch' => '0', 'pre_release' => 'alpha', 'build' => 'abc']],
        ];
    }

    /**
     * @dataProvider provideGoodCases
     */
    function testGoodCases($expr, array $expected) {
        $parser = new RegexParser();
        $actual = $parser->parse($expr);
        $this->assertEquals($expected, $actual);
    }
}