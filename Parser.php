<?php

class Parser implements Iterator {

    private $string;

    private $token;

    private $index;

    private $length;

    function parse($version) {
        $this->string = $version;
        $this->length = strlen($version);

        $this->rewind();
        $this->valid_semver();
    }

    function rewind() {
        $this->index = 0;
        $this->token = $this->string[$this->index];
    }
    function valid() {
        return $this->index < $this->length;
    }
    function key() {
        return $this->index;
    }
    function current() {
        return $this->token;
    }
    function next() {
        $this->index++;
        $this->token = $this->string[$this->index];
    }

    private function match($token) {
        if ($this->current() === $token) {
            $this->next();
        } else {
            throw new Exception;
        }
    }

    private function matches($token) {
        return $this->token === $token;
    }

    private function error() {
        throw new Exception(
            "Unexpected character '{$this->token}' at offset {$this->index}"
        );
    }

    private function valid_semver() {
        $this->version_core();
        if ($this->matches('-')) {
            $this->match('-');
            $this->pre_release();
            if ($this->matches('+')) {
                $this->match('+');
                $this->build();
            }
        } elseif ($this->matches('+')) {
            $this->match('+');
            $this->build();
        } else {
            $this->error();
        }
    }

    private function version_core() {
        $this->major();
        $this->match('.');
        $this->minor();
        $this->match('.');
        $this->patch();
    }
    private function pre_release() {

    }
    private function build() {

    }
    private function major() {
        $this->numeric_identifier();
    }
    private function minor() {
        $this->numeric_identifier();
    }
    private function patch() {
        $this->numeric_identifier();
    }

    private function numeric_identifier() {
        if ($this->matches('0')) {
            $this->match('0');
        }
    }
    private function dot_separated_pre_release_identifiers() {

    }

    private function pre_release_identifier() {

    }

    private function dot_separated_pre_build_identifiers() {

    }
    private function build_identifier() {

    }
    private function alphanumeric_identifier() {

    }
    private function digits() {

    }
    private function digit() {

    }
    private function non_digit() {

    }
    private function identifier_characters() {

    }

    private function positive_digit() {

    }
    private function identifier_character() {

    }

    private function letter() {

    }

}