<?php

spl_autoload_register(function($class) {
    $src = __DIR__ . '/../src';
    $test = __DIR__ . '/../test/unit';
    $identifier = str_replace('\\', '/', $class);
    switch($identifier) {
        case 'League/SemVer/Parser':
        case 'League/SemVer/RegexParser':
        case 'League/SemVer/CachingParser':
        case 'League/SemVer/Version':
            require "$src/$identifier.php";
            break;

        case 'League/SemVer/ParserTest':
            require "$test/$identifier.php";
    }
});