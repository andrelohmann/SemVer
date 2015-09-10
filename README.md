#SemVer

This is a [Semantic Versioning](http://semver.org/) 2.0.0 parser for PHP 5.4 and 5.5. It defines a simple interface `Parser` that validates that a version is properly formatted and parses it into a `Version` class:

```php
namespace League\SemVer;

interface Parser
{

    /**
     * @param string $version
     * @return Version
     */
    function parse($version);

    /**
     * @param string $version
     * @return bool
     */
    function isValidVersion($version);

}
```

##Usage

```php
$parser = new League\SemVer\RegexParser();
var_dump($parser->parse('not a valid version'));
var_dump($parser->parse('1.0.0-alpha.1+48e4f51e0b2751ec3bc4a2bde809e46d60eb1d6e'));
```

Result: 
```php
NULL
object(League\SemVer\Version)#3 (5) {
  ["major"]=>
  string(1) "1"
  ["minor"]=>
  string(1) "0"
  ["patch"]=>
  string(1) "0"
  ["pre_release"]=>
  array(2) {
    [0]=>
    string(5) "alpha"
    [1]=>
    int(1)
  }
  ["build"]=>
  array(1) {
    [0]=>
    string(40) "48e4f51e0b2751ec3bc4a2bde809e46d60eb1d6e"
  }
}
```

Note that there is `CachingParser` that can be used to cache the results of parsing, but some preliminary tests indicate that reparsing the version is actually faster.

##Requirements

 - PHP 5.4 or 5.5
 - PHPUnit (version unknown) - for running tests.

