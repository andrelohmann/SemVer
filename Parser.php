<?php


interface Parser {

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