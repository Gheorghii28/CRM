<?php
namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;

class TaskService {
    
    /**
     * Get task information including title, user name, status and due date for a specific period.
     *
     * This method retrieves tasks with their title, the associated user's name, and the due date
     * for tasks that were created within a specified date range.
     *
     * @param string $startDate The start date of the period (format: Y-m-d).
     * @param string $endDate The end date of the period (format: Y-m-d).
     * @return \Illuminate\Support\Collection A collection of tasks with title, user name, and due date.
     */
    public function getTaskInfoForPeriod($startDate, $endDate)
    {
        // Convert the start and end dates to Carbon instances to ensure proper date handling
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return Task::join('users', 'tasks.user_id', '=', 'users.id')
            ->whereBetween('tasks.created_at', [$start, $end]) 
            ->select(
                'tasks.title as title',
                'tasks.status as status',
                'users.name as user_name',
                'tasks.due_date as due_date'
            )
            ->get();
    }
}