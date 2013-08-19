<?php

namespace League\SemVer;

require __DIR__ . '/../../vendor/autoload.php';

$parsers = [
    $p = new RegexParser(),
    new CachingParser($p),
];

$versions = [
    "%1\$d.0.0",
    "%1\$d.0.0-alpha.%1\$d%1\$d",
    "%1\$d.0.0-alpha.1+%1\$d%1\$d",
    "bad version: %1\$d.%1\$d.%1\$d",
    "static cache version"
];

$iterations = 100000;

foreach ($versions as $fver) {
    foreach ($parsers as $parser) {
        /**
         * @var Parser $parser
         */
        $start = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $version = sprintf($fver, $i);
            if ($parser->isValidVersion($version)) {
                $parser->parse($version);
            }
        }
        $stop = microtime(true);
        printf("%s\t %s:\t%f\n", get_class($parser), $fver, $stop - $start);
    }
    printf("\n");
}
