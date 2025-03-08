<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;

if (!function_exists('convertGregorianDateToJalali')) {
    function convertGregorianDateToJalali($date): string
    {
        return jdate($date)->format('Y/m/d');
    }
}
if (! function_exists('convertJalaliDateToGregorian')) {
    function convertJalaliDateToGregorian(string $date, string $input_format = 'Y/m/d', string $output_format = 'Y-m-d'): ?string
    {
        list($jalaliYear, $jalaliMonth, $jalaliDay) = explode('/', $date);
        if(preg_match('/^\d{4}$/', $jalaliYear)) {
            return Jalalian::fromFormat($input_format, $date)->toCarbon()->format($output_format);
        }
        return 'Error Invalid Date';
    }
}


