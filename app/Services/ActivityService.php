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

    /**
    * Get the count of activities grouped by activity type.
    *
    * This function retrieves the number of activities for each activity type
    * by grouping the activities based on their type and counting the occurrences.
    * 
    * @return \Illuminate\Support\Collection
    */
    public function getActivityTypeCounts()
    {
        return Activity::select(Activity::raw('activity_type, COUNT(*) as count'))
                       ->groupBy('activity_type')
                       ->get();
    }

    /**
    * Searches for activities based on the given search term.
    *
    * This function builds a query that orders activities by their creation date
    * and optionally filters them based on the provided search term. The search
    * can be performed on the user's name, the customer's name, the activity type,
    * the activity description, or the creation date.
    *
    * @param string|null $search The search term to filter activities.
    * @return //The constructed query for the activities.
    */
    public function searchActivities($search)
    {
        $query = Activity::orderBy('date', 'asc');

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('firstname', 'like', "%{$search}%")
                          ->orWhere('lastname', 'like', "%{$search}%");
                })
                ->orWhere('activity_type', 'like', "%{$search}%")
                ->orWhere('activity_description', 'like', "%{$search}%")
                ->orWhereDate('created_at', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}