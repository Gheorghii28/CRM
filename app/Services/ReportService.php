<?php
namespace App\Services;

use App\Models\Report;
use Carbon\Carbon;

class ReportService {
    
    /**
    * Get report data for a specific period including user name, email, project title, duration, and status.
    *
    * This method retrieves report data from the database for a given time period. The data includes the user's name, 
    * email, the project title (report title), duration, and status of the report. Additionally, the number of reports 
    * returned can be limited by specifying a limit.
    *
    * @param string $startDate The start date of the period (format: Y-m-d).
    * @param string $endDate The end date of the period (format: Y-m-d).
    * @param int $limit The maximum number of reports to retrieve.
    * @return \Illuminate\Support\Collection A collection of reports within the specified period.
    */
    public function getReportDataForPeriod($startDate, $endDate, $limit)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return Report::join('users', 'reports.user_id', '=', 'users.id')
            ->whereBetween('reports.created_at', [$start, $end])
            ->select(
                'users.name as Name',
                'users.email as Email',
                'reports.report_title as Project',
                'reports.duration as Duration',
                'reports.status as Status'
            )
            ->take($limit)
            ->get();
    }
}