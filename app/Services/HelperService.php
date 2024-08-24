<?php
namespace App\Services;

class HelperService {

    /**
    * Format a number into a readable format (e.g., 1.2M, 3.5K).
    *
    * @param float $number
    * @param int $precision
    * @return string
    */
    function formatNumberForFrontend($number, $precision = 2)
    {
        if ($number >= 1000000) {
            return number_format($number / 1000000, $precision) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, $precision) . 'K';
        }

        return number_format($number, $precision);
    }
}