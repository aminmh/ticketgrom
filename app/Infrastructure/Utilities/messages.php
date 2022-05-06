<?php

if (!function_exists("json_message")) {

    function json_message(string $key, array $replace = [], string $locale = 'fa')
    {
        if (str_contains($key, '.'))

            return ['message' => __(strtoupper($key), $replace, $locale)];

        return ['message' => __("messages." . strtoupper($key), $replace, $locale)];
    }
}
