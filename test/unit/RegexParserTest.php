<?php

require_once 'ParserTest.php';
require_once __DIR__ . '/../../RegexParser.php';

class RegexParserTest extends ParserTest {

    function makeParser() {
        return new RegexParser();
    }
}