<?php

namespace App\Helpers;

class Helper
{
    public static function makeSlug($str)
    {
        $str = strtolower($str);
        $str = preg_replace("/[^a-z0-9]+/", '-', $str);
        $str = trim($str, '-');
        $str = $str . "-" . time();
        return $str;
    }
}
