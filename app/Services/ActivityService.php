<?php
namespace App\Services;

use App\Models\Activity;
use Carbon\Carbon;

class ActivityService {

    /**
     * Get activities for a specific period with a limit on the number of results.
     *
     * This method retrieves activities that were created between the given start and end dates.
     * Only the 'activity_type' and 'activity_description' fields are selected.
     * The number of activities returned is limited by the $limit parameter.
     *
     * @param string $startDate The start date for the period (format: Y-m-d).
     * @param string $endDate The end date for the period (format: Y-m-d).
     * @param int $limit The maximum number of activities to return.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the activities within the specified period.
     */
    public function getActivitiesForPeriod($startDate, $endDate, $limit) {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();
    
        $activities = Activity::whereBetween('created_at', [$start, $end])
            ->select('activity_type', 'activity_description')
            ->take($limit)
            ->get();
    
        return response()->json($activities);
    }
}