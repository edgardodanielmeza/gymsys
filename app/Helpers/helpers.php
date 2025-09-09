<?php

use App\Models\Setting;

if (!function_exists('format_money')) {
    /**
     * Formats a number to the application's currency format.
     *
     * @param float $value
     * @return string
     */
    function format_money($value)
    {
        // Cache settings to avoid multiple queries per request.
        static $settings = null;
        if (is_null($settings)) {
            $settings = Setting::all()->keyBy('key')->map->value;
        }

        $symbol = $settings->get('currency_symbol', '$');
        $decimalSeparator = $settings->get('decimal_separator', '.');
        $thousandsSeparator = $settings->get('thousands_separator', ',');

        // As per user request: "999.999.999,99"
        $decimalSeparator = ',';
        $thousandsSeparator = '.';

        return $symbol . ' ' . number_format($value, 2, $decimalSeparator, $thousandsSeparator);
    }
}
