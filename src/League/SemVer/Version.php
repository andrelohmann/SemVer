<?php

namespace League\SemVer;

class Version {

    public $major = 0;
    public $minor = 0;
    public $patch = 0;
    public $pre_release = [];
    public $build = [];

    public function __construct($major, $minor, $patch, $pre_release = [], $build = [])
    {
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
        $this->pre_release = $pre_release;
        $this->build = $build;
    }

    public static function compare(Version $a, Version $b)
    {
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

        if ($a->pre_release !== []) {
            if ($b->pre_release === []) {
                return -1;
            }
            $aCount = count($a->pre_release);
            $bCount = count($b->pre_release);
            $len = min($aCount, $bCount);
            for ($i = 0; $i < $len; $i++) {
                $aVal = $a->pre_release[$i];
                $bVal = $b->pre_release[$i];
                $is_int_a = is_int($aVal);
                $is_int_b = is_int($bVal);
                if ($is_int_a) {
                    if ($is_int_b && $aVal !== $bVal) {
                        return $aVal - $bVal;
                    }
                } elseif ($is_int_b) {
                    return 1;
                }
                $r = strcmp($aVal, $bVal);
                if ($r !== 0){
                    return $r;
                }
            }
            return $aCount - $bCount;

        } elseif ($b->pre_release !== []) {
            return 1;
        }


        return 0;
    }

}