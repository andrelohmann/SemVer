<?php

class RegexParser {

    private $regex = "/
        (?P<major>\d+)
        \.
        (?P<minor>\d+)
        \.
        (?P<patch>\d+)
        (?:
            \-
            (?P<pre_release>[a-zA-Z0-0]+(?:\.[a-zA-Z0-9]+)*)
        )?
        (?:
            \+
            (?P<build>[a-zA-Z0-0]+(?:\.[a-zA-Z0-9]+)*)
        )?
    /x";

    function parse($version) {
        $matches = array();
        if (preg_match($this->regex, $version, $matches)) {
            $variables = array_diff_key(
                $matches,
                array_fill_keys(range(0,count($matches)/2), 0)
            );
            return $variables;
        }
        return FALSE;
    }

}
