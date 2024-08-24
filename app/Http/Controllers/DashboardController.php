<?php

namespace App\Http\Controllers;

use App\Services\DealService;
use App\Services\EmployeeService;
use App\Services\FinancialService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\CustomerService;
use App\Services\HelperService;

class DashboardController extends Controller
{
    protected $customerService;
    protected $dealService;
    protected $employeeService;
    protected $financialService;
    protected $helperService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerService $customerService, DealService $dealService, EmployeeService $employeeService, FinancialService $financialService, HelperService $helperService)
    {
        $this->middleware('auth');
        $this->customerService = $customerService;
        $this->dealService = $dealService;
        $this->employeeService = $employeeService;
        $this->financialService = $financialService;
        $this->helperService = $helperService;
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

         $days = 7;
         $endDate = Carbon::now();
         $startDate = Carbon::now()->subDays($days);
         
        if ($request->has('start_date') && $request->has('end_date') && $request->has('days')) {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $days = $request->input('days');
        }

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
        
        $days = 7;
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays($days);
        
       if ($request->has('start_date') && $request->has('end_date')) {
           $startDate = Carbon::parse($request->input('start_date'));
           $endDate = Carbon::parse($request->input('end_date'));
           $days = $request->input('days');
       }

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
}
