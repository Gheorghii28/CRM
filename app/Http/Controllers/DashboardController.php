<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Note;
use App\Models\Task;
use App\Services\ActivityService;
use App\Services\DealService;
use App\Services\EmployeeService;
use App\Services\FinancialService;
use App\Services\NoteService;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\CustomerService;
use App\Services\HelperService;
use App\Services\ReportService;

class DashboardController extends Controller
{
    protected $customerService;
    protected $dealService;
    protected $employeeService;
    protected $financialService;
    protected $helperService;
    protected $activityService;
    protected $reportService;
    protected $noteService;
    protected $taskService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerService $customerService, DealService $dealService, EmployeeService $employeeService, FinancialService $financialService, HelperService $helperService, ActivityService $activityService, ReportService $reportService, NoteService $noteService, TaskService $taskService)
    {
        $this->middleware('auth');
        $this->customerService = $customerService;
        $this->dealService = $dealService;
        $this->employeeService = $employeeService;
        $this->financialService = $financialService;
        $this->helperService = $helperService;
        $this->activityService = $activityService;
        $this->reportService = $reportService;
        $this->noteService = $noteService;
        $this->taskService = $taskService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard.index');
    }

    public function fetchStatistics(Request $request) {

        $dateRange = $this->helperService->getStartAndEndDates($request);
        $startDate = $dateRange['start_date'];
        $endDate = $dateRange['end_date'];
        $days = $dateRange['days'];

        $newCustomersPerDay = $this->customerService->getNewCustomersPerDay($startDate, $endDate);
        $newTotalCustomers = $this->customerService->getNewTotalCustomers($startDate, $endDate);
        $customerTrendPercentage = $this->customerService->getCustomerTrendPercentage($startDate, $endDate, $days);

        $dealDistribution = $this->dealService->getDealDistributionPercentage($startDate, $endDate);
        $newTotalDeal = $this->dealService->getNewTotalDeals($startDate, $endDate);
        $dealTrendPercentage = $this->dealService->getDealCategoryTrend($startDate, $endDate, $days);

        $newSalesEmployees = $this->employeeService->getNewSalesEmployeesPerDay($startDate, $endDate);
        $newTotalSalesEmplyees = $this->employeeService->getNewTotalSalesEmployees($startDate, $endDate);
        $salesEmployeesTrendPercentage = $this->employeeService->getSalesEmployeeTrendPercentage($startDate, $endDate, $days);

        $customerData = [
            'date_per_day' => $newCustomersPerDay->pluck('date')->toArray(),
            'total_per_day' => $newCustomersPerDay->pluck('total')->toArray(),
            'new_total' => $newTotalCustomers,
            'trend_percentage' => $customerTrendPercentage,
        ];

        $dealData = [
            'keys' => array_keys($dealDistribution),
            'values' => array_values($dealDistribution),
            'new_total' => $newTotalDeal,
            'trend_percentage' => $dealTrendPercentage,
        ];

        $employeeData = [
            'date_per_day' => $newSalesEmployees->pluck('date')->toArray(),
            'total_per_day' => $newSalesEmployees->pluck('total')->toArray(),
            'new_total' => $newTotalSalesEmplyees,
            'trend_percentage' => $salesEmployeesTrendPercentage,
        ];

        $data = [
            'customer' => $customerData,
            'deal' => $dealData,
            'employee' => $employeeData,
        ];

        return response()->json($data);
    }

    public function fetchFinancials(Request $request) {

       $dateRange = $this->helperService->getStartAndEndDates($request);
       $startDate = $dateRange['start_date'];
       $endDate = $dateRange['end_date'];

       $receivedAmountPerDay = $this->financialService->getReceivedAmountPerDay($startDate, $endDate);

       $totalReceivedAmountForPeriod = $this->financialService->getTotalReceivedAmountForPeriod($startDate, $endDate);
       $totalDueAmountForPeriod = $this->financialService->getTotalDueAmountForPeriod($startDate, $endDate);
       $totalReceivedAmountForPeriodFormated = $this->helperService->formatNumberForFrontend($totalReceivedAmountForPeriod);
       $totalDueAmountForPeriodFormated = $this->helperService->formatNumberForFrontend($totalDueAmountForPeriod);

       $data = [
        'date_per_day' => $receivedAmountPerDay->pluck('date')->toArray(),
        'total_per_day' => $receivedAmountPerDay->pluck('total_received')->toArray(),
        'total_received_for_period' => $totalReceivedAmountForPeriodFormated,
        'total_due_for_period' => $totalDueAmountForPeriodFormated,
       ];

       return response()->json($data);
    }

    public function fetchActivities(Request $request) {
                
        $dateRange = $this->helperService->getStartAndEndDates($request);
        $startDate = $dateRange['start_date'];
        $endDate = $dateRange['end_date'];
        $limit = $dateRange['limit'];

        return $this->activityService->getActivitiesForPeriod($startDate, $endDate, $limit);
    }

    public function getLatestActivities($nr) {
                
        $activities = Activity::orderBy('created_at', 'desc')
        ->select('activity_type', 'activity_description')
        ->take($nr)
        ->get();

        return response()->json($activities);
    }

    public function fetchReports(Request $request) {
                
        $dateRange = $this->helperService->getStartAndEndDates($request);
        $startDate = $dateRange['start_date'];
        $endDate = $dateRange['end_date'];
        $limit = $dateRange['limit'];

        return $this->reportService->getReportDataForPeriod($startDate, $endDate, $limit);
    }

    public function fetchNotes(Request $request) {
                
        $dateRange = $this->helperService->getStartAndEndDates($request);
        $startDate = $dateRange['start_date'];
        $endDate = $dateRange['end_date'];
        $limit = $dateRange['limit'];

        return $this->noteService->getNotesWithDealsForPeriod($startDate, $endDate, $limit);
    }

    public function getLatestNotes($nr)
    {
        return Note::join('deals', 'notes.deal_id', '=', 'deals.id')
        ->orderBy('notes.created_at', 'desc')
        ->select(
            'deals.deal_name as deal_name',
            'notes.note_content as note',
        )
        ->take($nr)
        ->get();
    }

    public function fetchTasks(Request $request) {
                
        $dateRange = $this->helperService->getStartAndEndDates($request);
        $startDate = $dateRange['start_date'];
        $endDate = $dateRange['end_date'];

        return $this->taskService->getTaskInfoForPeriod($startDate, $endDate);
    }

    public function getLatestTasks($nr) {
        return Task::join('users', 'tasks.user_id', '=', 'users.id')
        ->orderBy('tasks.created_at', 'desc') 
        ->select(
            'tasks.title as title',
            'tasks.status as status',
            'users.name as user_name',
            'tasks.due_date as due_date'
        )
        ->take($nr)
        ->get();
    }
}
