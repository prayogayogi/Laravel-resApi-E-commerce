<?php

if (!function_exists('moneyFormat')) {
    /**
     * moneyFormat
     *
     * @param  mixed $str
     * @return String
     */
    function moneyFormat($str): String
    {
        return 'Rp. ' . number_format($str, '0', '', '.');
    }
}

if (!function_exists('dateID')) {
    /**
     * dateID
     *
     * @param  mixed $tanggal
     * @return String
     */
    function dateID($tanggal): String
    {
        $value = Carbon\Carbon::parse($tanggal);
        $parse = $value->locale('id');
        return $parse->translatedFormat('l, d F Y');
    }
}
