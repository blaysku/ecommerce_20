<?php

namespace App\Helpers;

class FormatData
{
    public static function currency($price = 0)
    {
        return number_format($price * config('setting.currency_unit')) . ' ' . config('setting.currency');
    }
}
