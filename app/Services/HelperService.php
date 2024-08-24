<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;

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

    /**
     * Get the start and end dates for a given period.
     *
     * @param Request $request
     * @return array
     */
    function getStartAndEndDates(Request $request)
    {
        $days = 7;
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays($days);
    
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $days = $request->input('days');
            $limit = (int) $request->input('limit');
        }
    
        return [
            'start_date' => $startDate->startOfDay()->format('Y-m-d H:i:s'),
            'end_date' => $endDate->endOfDay()->format('Y-m-d H:i:s'),
            'days' => $days,
            'limit' => $limit,
        ];
    }
}