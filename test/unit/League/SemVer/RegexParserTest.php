<?php

namespace League\Semver;

class RegexParserTest extends ParserTest
{

    function makeParser()
    {
        return new RegexParser();
    }
}