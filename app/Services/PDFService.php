<?php
namespace App\Services;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
class PDFService {
    public function generatePDF($viewName, $data)
    {
        $pdf = Pdf::loadView($viewName, $data);
        return $pdf;
    }

    public function getActivityDataForPDF($id)
    {
        $activity = Activity::with(['user', 'customer', 'deal'])->find($id);
        $users = User::all(['id', 'name']);
        $customers = Customer::all(['id', 'firstname', 'lastname']);
        $deals = Deal::all(['id', 'deal_name']);
        $pdfCSS = file_get_contents(public_path('css/pdf-activity-info.css'));
        
        return [
            'activity' => $activity,
            'users' => $users,
            'customers' => $customers,
            'deals' => $deals,
            'pdfCSS' => $pdfCSS
        ];
    }

    public function getCustomerDataForPDF() 
    {
        $currentPage = request()->get('page', 1);
        $query = Customer::orderBy('created_at', 'asc');
        $customers = $query->paginate(20, ['*'], 'page', $currentPage);
        $pdfCSS = file_get_contents(public_path('css/pdf-customers-table.css'));
        
        return [
            'customers' => $customers,
            'pdfCSS' => $pdfCSS
        ];
    }

}