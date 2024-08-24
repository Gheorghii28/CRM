<?php
namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class EmployeeService {

    /**
     * Get the total number of new sales employees for a given period.
     *
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    public function getNewTotalSalesEmployees($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return User::where('role', 'sales')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
    }

    /**
     * Get the number of new sales employees per day for a given period.
     *
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Support\Collection
     */
    public function getNewSalesEmployeesPerDay($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return User::where('role', 'sales')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * Get the percentage trend of new sales employees compared to the previous period.
     *
     * @param string $currentStartDate
     * @param string $currentEndDate
     * @param int $days
     * @return float
     */
    public function getSalesEmployeeTrendPercentage($currentStartDate, $currentEndDate, $days)
    {
        $currentStart = Carbon::parse($currentStartDate)->startOfDay();
        $currentEnd = Carbon::parse($currentEndDate)->endOfDay();
        $previousStart = $currentStart->copy()->subDays($days);
        $previousEnd = $currentEnd->copy()->subDays($days);
        $currentPeriodSalesEmployees = User::where('role', 'sales')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->count();
        $previousPeriodSalesEmployees = User::where('role', 'sales')
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();

        if ($previousPeriodSalesEmployees == 0) {
           return $currentPeriodSalesEmployees > 0 ? 100 : 0;
        }

        $percentageChange = (($currentPeriodSalesEmployees - $previousPeriodSalesEmployees) / $previousPeriodSalesEmployees) * 100;

        return round($percentageChange,2);
    }
}