<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;

class FinancialService {

    /**
     * Get the total received amount for a specific period.
     *
     * @param string $startDate
     * @param string $endDate
     * @return float
     */
    public function getTotalReceivedAmountForPeriod($startDate, $endDate)
    {
        return Payment::completed()
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->sum('amount');
    }

    /**
     * Get the total due amount for a specific period.
     *
     * @param string $startDate
     * @param string $endDate
     * @return float
     */
    public function getTotalDueAmountForPeriod($startDate, $endDate)
    {
        return Invoice::unpaid()
            ->whereBetween('due_date', [$startDate, $endDate])
            ->sum('total_amount');
    }

    /**
     * Get the total received amount per day for a given period.
     *
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Support\Collection
     */
    public function getReceivedAmountPerDay($startDate, $endDate)
    {
        // Konvertiere die Start- und Enddaten in Carbon-Instanzen
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return Payment::completed()
            ->whereBetween('payment_date', [$start, $end])
            ->select(Payment::raw('DATE(payment_date) as date'), Payment::raw('SUM(amount) as total_received'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }
}