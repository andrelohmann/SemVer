<?php

require_once 'Version.php';
require_once 'Parser.php';

class RegexParser implements Parser {

    private $regex = "/^
        (?#major)(0|(?:[1-9][0-9]*))
        \\.
        (?#minor)(0|(?:[1-9][0-9]*))
        \\.
        (?#patch)(0|(?:[1-9][0-9]*))
        (?:
            -
            (?#pre-release)(
                (?:(?:0|(?:[1-9][0-9]*))|(?:[0-9]*[a-zA-Z-][a-zA-Z0-9-]*))
                (?:
                    \\.
                    (?:(?:0|(?:[1-9][0-9]*))|(?:[0-9]*[a-zA-Z-][a-zA-Z0-9-]*))
                )*
            )
        )?
        (?:
            \\+
            (?#build)(
                [0-9a-zA-Z-]+
                (?:\\.[a-zA-Z0-9-]+)*
            )
        )?
    \$/x";

    function parse($version) {
        $matches = array();
        if ($r = @preg_match($this->regex, $version, $matches)) {

            $matches[4] = empty($matches[4])
                ? []
                : explode('.', $matches[4]);

            $matches[5] = empty($matches[5])
                ? []
                : explode('.', $matches[5]);

            return new Version(
                $matches[1],
                $matches[2],
                $matches[3],
                $matches[4],
                $matches[5]
            );
        }
        if ($r === FALSE) {
            throw new Exception(preg_last_error());
        }
        return NULL;
    }

    function isValidVersion($string) {
        return preg_match($this->regex, $string) === 1;
    }

}
