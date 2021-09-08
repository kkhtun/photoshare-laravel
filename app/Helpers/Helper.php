<?php

namespace App\Helpers;

class Helper
{
    public static function makeSlug($str)
    {
        $str = strtolower($str);
        $str = str_replace(" ", "-", $str);
        $str = $str . "-" . time();
        return $str;
    }
}
