<?php
namespace App\Services;

use App\Models\Customer;
use Carbon\Carbon;

class CustomerService {

    /**
     * Get the total number of new customers for a given period.
     *
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    public function getNewTotalCustomers($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return Customer::whereBetween('created_at', [$start, $end])->count();
    }

    /**
     * Get the number of new customers per day for a given period.
     *
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Support\Collection
     */
    public function getNewCustomersPerDay($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return Customer::whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * Get the percentage trend of new customers compared to the previous period.
     *
     * @param string $currentStartDate
     * @param string $currentEndDate
     * @param int $days
     * @return float
     */
    public function getCustomerTrendPercentage($currentStartDate, $currentEndDate, $days)
    {
        $currentStart = Carbon::parse($currentStartDate)->startOfDay();
        $currentEnd = Carbon::parse($currentEndDate)->endOfDay();
        $previousStart = $currentStart->copy()->subDays($days);
        $previousEnd = $currentEnd->copy()->subDays($days);
        $currentPeriodCustomers = Customer::whereBetween('created_at', [$currentStart, $currentEnd])->count();
        $previousPeriodCustomers = Customer::whereBetween('created_at', [$previousStart, $previousEnd])->count();

        if ($previousPeriodCustomers == 0) {
            return $currentPeriodCustomers > 0 ? 100 : 0;
        }

        $percentageChange = (($currentPeriodCustomers - $previousPeriodCustomers) / $previousPeriodCustomers) * 100;

        return round($percentageChange, 2);
    }
}