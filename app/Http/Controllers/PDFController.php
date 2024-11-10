<?php

namespace App\Http\Controllers;

use App\Services\PDFService;

class PDFController extends Controller
{
    protected $activityService;
    protected $pdfService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PDFService $pdfService)
    {
        $this->middleware('auth');
        $this->pdfService = $pdfService;
    }

    public function viewPDF($viewName, $data = [])
    {
        $pdf = $this->pdfService->generatePDF($viewName, $data);
        return $pdf->stream();
    }    

    public function downloadPDF($viewName, $data = [], $fileName = 'document.pdf')
    {
        $pdf = $this->pdfService->generatePDF($viewName, $data);
        return $pdf->download($fileName);   
    }  

    public function generateActivityPDFForViewing($id)
    {
        $data = $this->pdfService->getActivityDataForPDF($id);

        return $this->viewPDF('activities.partials.activity-info', $data);
    }

    public function generateActivityPDFForDownload($id)
    {
        $data = $this->pdfService->getActivityDataForPDF($id);
        $fileName = 'activity-' . $id . '.pdf';

        return $this->downloadPDF('activities.partials.activity-info', $data, $fileName);
    }

    public function generateCustomersPDFForViewing()
    {
        $data = $this->pdfService->getCustomerDataForPDF();

        return $this->viewPDF('customers.partials.table', $data);
    }

    public function generateCustomersPDFForDownload()
    {
        $data = $this->pdfService->getCustomerDataForPDF();
        $currentPage = request()->get('page', 1);
        $fileName = 'customers-page-' . $currentPage . '.pdf';

        return $this->downloadPDF('customers.partials.table', $data, $fileName);
    }

}
