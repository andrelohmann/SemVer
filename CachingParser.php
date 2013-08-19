<?php

class CachingParser implements Parser, Countable {

    /**
     * @var Parser
     */
    private $inner;

    private $limit = 0;

    private $cache = [];

    function __construct(Parser $parser, $limit = 10) {
        $this->inner = $parser;
        $this->limit = $limit;
    }

    /**
     * @param string $version
     * @return Version
     */
    function parse($version) {
        if (array_key_exists($version, $this->cache)) {
            $obj = $this->cache[$version];
            unset($this->cache[$version]);
            $this->cache[$version] = $obj;
        } else {
            if (count($this->cache) == $this->limit) {
                array_shift($this->cache);
            }
            $this->cache[$version] = $obj = $this->inner->parse($version);
        }
        return $obj;
    }

    /**
     * @param string $version
     * @return bool
     */
    function isValidVersion($version) {
        return $this->parse($version) !== NULL;
    }

    function count() {
        return count($this->cache);
    }

    function flush() {
        $this->cache = [];
    }

    function getLimit() {
        return $this->limit;
    }

    function isInCache($version) {
        return array_key_exists($version, $this->cache);
    }

}