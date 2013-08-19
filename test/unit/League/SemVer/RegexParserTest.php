<?php

namespace League\SemVer;

class RegexParserTest extends ParserTest
{

    function makeParser()
    {
        return new RegexParser();
    }
}