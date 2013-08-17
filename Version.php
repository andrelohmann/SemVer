<?php

class Version {

    public $major = 0;
    public $minor = 0;
    public $patch = 0;
    public $pre_release = '';
    public $build = '';

    function __construct($major, $minor, $patch, $pre_release = '', $build = '') {
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
        $this->pre_release = $pre_release;
        $this->build = $build;
    }

    static function compare(Version $a, Version $b) {
        if ($a->major < $b->major) {
            return -1;
        } elseif ($b->major < $a->major) {
            return 1;
        }

        if ($a->minor < $b->minor) {
            return -1;
        } elseif ($b->minor < $a->minor) {
            return 1;
        }

        if ($a->patch < $b->patch) {
            return -1;
        } elseif ($b->patch < $a->patch) {
            return 1;
        }

        if ($a->pre_release !== '') {
            if ($b->pre_release === '') {
                return -1;
            }

        }

        return 0;
    }

}