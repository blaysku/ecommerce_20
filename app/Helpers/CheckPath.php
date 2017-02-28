<?php

namespace App\Helpers;

use Request;

class CheckPath
{
    const CLASS_ACTIVE = ' class="active"';
    const ACTIVE = ' active';

    public static function classActivePath($path)
    {
        return Request::is($path) ? self::CLASS_ACTIVE : null;
    }

    public static function classActiveSegment($segment, $value)
    {
        if (!is_array($value)) {
            return Request::segment($segment) == $value ? self::CLASS_ACTIVE : null;
        }

        foreach ($value as $v) {
            if (Request::segment($segment) == $v) {
                return self::CLASS_ACTIVE;
            }
        }

        return null;
    }

    public static function classActiveOnlyPath($path)
    {
        return Request::is($path) ? self::ACTIVE : null;
    }

    public static function classActiveOnlySegment($segment, $value)
    {
        if (!is_array($value)) {
            return Request::segment($segment) == $value ? self::ACTIVE : null;
        }

        foreach ($value as $v) {
            if (Request::segment($segment) == $v) {
                return self::ACTIVE;
            }
        }
        
        return null;
    }
}
