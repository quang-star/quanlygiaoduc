<?php

use App\Models\Setting;
if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $s = Setting::where('key', $key)->first();
        return $s ? $s->value : $default;
    }
}