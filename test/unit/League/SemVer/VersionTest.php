<?php

namespace League\Semver;

class VersionTest extends \PHPUnit_Framework_TestCase
{

    function provideEqualCases()
    {
        return [
            '0.0.0 == 0.0.0' => [
                [0, 0, 0, [], []],
                [0, 0, 0, [], []],
            ],
            '0.1.0 == 0.1.0' => [
                [0, 1, 0, [], []],
                [0, 1, 0, [], []],
            ],
            '1.0.0 == 1.0.0' => [
                [1, 0, 0, [], []],
                [1, 0, 0, [], []],
            ],
        ];
    }

    function provideLessThanCases()
    {
        return [
            '1.0.0 vs 2.0.0' => [
                [1, 0, 0, [], []],
                [2, 0, 0, [], []],
            ],
            '2.0.0 vs 2.1.0' => [
                [2, 0, 0, [], []],
                [2, 1, 0, [], []],
            ],
            '2.1.0 vs 2.1.1' => [
                [2, 1, 0, [], []],
                [2, 1, 1, [], []],
            ],
            '1.0.0-alpha vs 1.0.0' => [
                [1, 0, 0, ['alpha'], []],
                [1, 0, 0, [], []],
            ],
            '1.0.0-alpha vs 1.0.0-alpha.1' => [
                [1, 0, 0, ['alpha'], []],
                [1, 0, 0, ['alpha','1'], []],
            ],
            '1.0.0-alpha.1 vs 1.0.0-alpha.beta' => [
                [1, 0, 0, ['alpha','1'], []],
                [1, 0, 0, ['alpha','beta'], []],
            ],
            '1.0.0-alpha.beta vs 1.0.0-beta' => [
                [1, 0, 0, ['alpha','beta'], []],
                [1, 0, 0, ['beta'], []],
            ],
            '1.0.0-beta vs 1.0.0-beta.2' => [
                [1, 0, 0, ['beta'], []],
                [1, 0, 0, ['beta','2'], []],
            ],
            '1.0.0-beta.2 vs 1.0.0-beta.11' => [
                [1, 0, 0, ['beta','2'], []],
                [1, 0, 0, ['beta','11'], []],
            ],
            '1.0.0-beta.11 vs 1.0.0-rc.1' => [
                [1, 0, 0, ['beta','11'], []],
                [1, 0, 0, ['rc.1'], []],
            ],
            '1.0.0-rc.1 vs 1.0.0' => [
                [1, 0, 0, ['rc','1'], []],
                [1, 0, 0, [], []],
            ],
        ];
    }

    function makeVersion(array $values)
    {
        return new Version(
            $values[0],
            $values[1],
            $values[2],
            $values[3],
            $values[4]
        );
    }

    /**
     * @dataProvider provideEqualCases
     */
    function testEqualCases($aArray, $bArray)
    {
        $a = $this->makeVersion($aArray);
        $b = $this->makeVersion($bArray);
        $actual = Version::compare($a, $b);
        $this->assertEquals(0, $actual);
    }

    /**
     * @dataProvider provideLessThanCases
     */
    function testLessThanCases($aArray, $bArray)
    {
        $a = $this->makeVersion($aArray);
        $b = $this->makeVersion($bArray);

        $actual = Version::compare($a, $b);
        $this->assertLessThan(0, $actual);

        $actual = Version::compare($b, $a);
        $this->assertGreaterThan(0, $actual);
    }

}