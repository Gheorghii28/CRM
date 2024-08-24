<?php
namespace App\Services;
use App\Models\Deal;
use Carbon\Carbon;

class DealService {

    /**
     * Get the total number of new deals for a given period.
     *
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    public function getNewTotalDeals($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return Deal::whereBetween('created_at', [$start, $end])->count();
    }

    /**
     * Get the percentage distribution of new deals by categories (active, closed, lost) within a given period.
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getDealDistributionPercentage($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();
        $deals = Deal::where(function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end])
                  ->orWhereBetween('updated_at', [$start, $end]);
        })->get();
        $totalDeals = $deals->count();

        if ($totalDeals == 0) {
            return [
                'Active Deals' => 0,
                'Closed Deals' => 0,
                'Lost Deals' => 0,
            ];
        }

        $activeDeals = $deals->whereIn('stage', ['prospecting', 'proposal', 'negotiation'])->count();
        $closedDeals = $deals->where('stage', 'won')->count();
        $lostDeals = $deals->where('stage', 'lost')->count();

        $activePercentage = ($activeDeals / $totalDeals) * 100;
        $closedPercentage = ($closedDeals / $totalDeals) * 100;
        $lostPercentage = ($lostDeals / $totalDeals) * 100;

        return [
            'Active Deals' => round($activePercentage, 1),
            'Closed Deals' => round($closedPercentage, 1),
            'Lost Deals' => round($lostPercentage, 1),
        ];
    }

     /**
     * Get the trend of each category (active, closed, lost) by comparing the current period with the previous period.
     *
     * @param string $currentStartDate
     * @param string $currentEndDate
     * @param int $days
     * @return array
     */
    public function getDealCategoryTrend($currentStartDate, $currentEndDate, $days)
    {
        $currentStart = Carbon::parse($currentStartDate)->startOfDay();
        $currentEnd = Carbon::parse($currentEndDate)->endOfDay();
        $previousStart = $currentStart->copy()->subDays($days);
        $previousEnd = $currentEnd->copy()->subDays($days);

        $currentDeals = Deal::where(function ($query) use ($currentStart, $currentEnd) {
            $query->whereBetween('created_at', [$currentStart, $currentEnd])
                  ->orWhereBetween('updated_at', [$currentStart, $currentEnd]);
        })->get();
        $previousDeals = Deal::where(function ($query) use ($previousStart, $previousEnd) {
            $query->whereBetween('created_at', [$previousStart, $previousEnd])
                  ->orWhereBetween('updated_at', [$previousStart, $previousEnd]);
        })->get();

        $currentActive = $currentDeals->whereIn('stage', ['prospecting', 'proposal', 'negotiation'])->count();
        $currentClosed = $currentDeals->where('stage', 'won')->count();
        $currentLost = $currentDeals->where('stage', 'lost')->count();

        $previousActive = $previousDeals->whereIn('stage', ['prospecting', 'proposal', 'negotiation'])->count();
        $previousClosed = $previousDeals->where('stage', 'won')->count();
        $previousLost = $previousDeals->where('stage', 'lost')->count();

        $activeTrend = $this->calculateTrend($currentActive, $previousActive);
        $closedTrend = $this->calculateTrend($currentClosed, $previousClosed);
        $lostTrend = $this->calculateTrend($currentLost, $previousLost);

        return [
            'active_trend' => round($activeTrend,2),
            'closed_trend' => round($closedTrend,2),
            'lost_trend' => round($lostTrend,2),
        ];
    }

    /**
     * Calculate the percentage change between two values.
     *
     * @param int $currentValue
     * @param int $previousValue
     * @return float
     */
    private function calculateTrend($currentValue, $previousValue)
    {
        if ($previousValue == 0) {
            return $currentValue > 0 ? 100 : 0;
        }

        return (($currentValue - $previousValue) / $previousValue) * 100;
    }
}