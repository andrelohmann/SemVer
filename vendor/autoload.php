<?php

spl_autoload_register(function($class) {
    $src = __DIR__ . '/../src';
    $test = __DIR__ . '/../test/unit';
    $identifier = str_replace('\\', '/', $class);
    switch($identifier) {
        case 'League/Semver/Parser':
        case 'League/Semver/RegexParser':
        case 'League/Semver/CachingParser':
        case 'League/Semver/Version':
            require "$src/$identifier.php";
            break;

        case 'League/Semver/ParserTest':
            require "$test/$identifier.php";
    }
});