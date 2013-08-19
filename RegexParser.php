<?php

class RegexParser {

    private $regex = "/^
        (?P<major>0|(?:[1-9][0-9]*))
        \.
        (?P<minor>0|(?:[1-9][0-9]*))
        \.
        (?P<patch>0|(?:[1-9][0-9]*))
        (?:
            \-
            (?P<pre_release>
                (?:(?:0|(?:[1-9][0-9]*))|(?:[a-zA-Z1-9-][a-zA-Z0-9-]*))
                (?:
                    \.
                    (?:(?:0|(?:[1-9][0-9]*))|(?:[a-zA-Z1-9-][a-zA-Z0-9-]*))
                )*
            )
        )?
        (?:
            \+
            (?P<build>
                [0-9a-zA-Z-]+
                (?:\.[a-zA-Z0-9-]+)*
            )
        )?
    \$/x";

    function parse($version) {
        $matches = array();
        if ($r = @preg_match($this->regex, $version, $matches)) {
            $variables = array_diff_key(
                $matches,
                array_fill_keys(range(0,count($matches)/2), 0)
            );
            return $variables;
        }
        if ($r === FALSE) {
            throw new Exception(preg_last_error());
        }
        return FALSE;
    }

}
