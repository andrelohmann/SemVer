<?php

namespace League\Semver;

class CachingParserTest extends ParserTest
{

    function makeParser()
    {
        return new CachingParser(new RegexParser());
    }

    function testCachingParser()
    {
        $cacheLimit = 10;
        $parser = new CachingParser(new RegexParser(), $cacheLimit);

        for ($i = 0; $i < $cacheLimit + 1; $i++) {
            $version = "$i.0.0";
            $this->assertFalse($parser->isInCache($version));
            $actual = $parser->parse($version);
            $this->assertEquals(new Version($i, 0, 0), $actual);
            $this->assertTrue($parser->isInCache($version));
            $this->assertTrue($parser->isValidVersion($version));
            $this->assertTrue($parser->isInCache($version));
        }

        for ($i = 0; $i < $cacheLimit + 1; $i++) {
            $version = "$i.0.0";
            $this->assertFalse($parser->isInCache($version));
            $this->assertTrue($parser->isValidVersion($version));
            $this->assertTrue($parser->isInCache($version));
            $actual = $parser->parse($version);
            $this->assertEquals(new Version($i, 0, 0), $actual);
            $this->assertTrue($parser->isInCache($version));
        }

        $this->assertCount($cacheLimit, $parser);
        $this->assertEquals($cacheLimit, $parser->getLimit());

        $parser->flush();
        $this->assertCount(0, $parser);
        $this->assertEquals($cacheLimit, $parser->getLimit());

    }

}