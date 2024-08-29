<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Deal;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
class CustomerController extends Controller
{
    protected $customerService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function validateCustomer(Request $request)
    {
        return $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^\+?[0-9\s\-]{7,15}$/',
            'city' => 'required|max:255',
            'stateprovince' => 'required|max:255',
            'streetaddress' => 'required|max:255',
            'zip' => 'required|numeric',
            'country' => 'required|max:255',
        ]);
    }

    private function searchCustomers($search)
    {
        $query = Customer::orderBy('created_at', 'asc');

        if ($search) {
            $query->where('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('stateprovince', 'like', "%{$search}%")
                  ->orWhere('streetaddress', 'like', "%{$search}%")
                  ->orWhere('zip', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
        }

        return $query;
    }

    /**
     * Show the application customers.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $query = Customer::orderBy('created_at', 'asc');

        $customers = $query->paginate(20);

        return view('customers.index', ['customers'=> $customers]);
    }

    public function search(Request $request) {
        $search = $request->input('search');
        $query = $this->searchCustomers($search);
        $customers = $query->paginate(20)->appends(['search' => $search]);

        return view('customers.index', ['customers'=> $customers, 'search' => $search]);   
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $validated = $this->validateCustomer($request);

        try {
            $customer = Customer::create($validated);
            
            return redirect()->route('customers.index')
                ->with('success', "Customer {$customer->firstname} {$customer->lastname} created successfully.");
        } catch (\Exception $e) {
        
            return redirect()->route('customers.index')
                ->withErrors(['error' => 'Failed to create customer: ' . $e->getMessage()]);
        } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $this->validateCustomer($request);
    
        try {
            $customer = Customer::findOrFail($id);
            $customer->update($validated);

            $redirectRoute = $request->input('redirect_to') === 'customers.show-profile' 
            ? route('customers.show-profile', $customer->id)
            : route('customers.index');
    
            return redirect($redirectRoute)
            ->with('success', "Customer {$customer->firstname} {$customer->lastname} updated successfully.");        
        } catch (\Exception $e) {
            return redirect()->route('customers.index')
                ->withErrors(['error' => 'Failed to update customer: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();
            
            return redirect()->route('customers.index')
                ->with('success', "Customer {$customer->firstname} {$customer->lastname} deleted successfully.");
        } catch (\Exception $e) {
            return redirect()->route('customers.index')
                ->withErrors(['error' => 'Failed to delete customer: ' . $e->getMessage()]);
        }
    }   

    /**
    * Retrieve the customer data by ID.
    */
    public function getCustomer($id)
    {
      $customer = Customer::find($id);
      
      return response()->json($customer);
    }

    /**
    * Display the specified resource.
    */
    public function showProfile(string $id)
    {
        $customer = Customer::with([
            'contacts',        
            'activities.user', 
            'deals',           
            'invoices', 
            'payments',
            'notes.user',      
            'transactions'     
        ])->findOrFail($id);

        $totalDealValue = $customer->totalDealValue();
        $outstandingBalance = $customer->outstandingBalance();
        
        $deals = Deal::where('customer_id', $id)->pluck('deal_value', 'created_at');
        $payments = Payment::where('customer_id', $id)->pluck('amount', 'payment_date');
        $invoices = Invoice::where('customer_id', $id)->pluck('total_amount', 'created_at');
        $transactions = Transaction::where('customer_id', $id)->pluck('amount', 'transaction_date');

        $formattedDeals = $deals->mapWithKeys(fn($value, $key) => [\Carbon\Carbon::parse($key)->format('Y-m-d') => $value]);
        $formattedPayments = $payments->mapWithKeys(fn($value, $key) => [\Carbon\Carbon::parse($key)->format('Y-m-d') => $value]);
        $formattedInvoices = $invoices->mapWithKeys(fn($value, $key) => [\Carbon\Carbon::parse($key)->format('Y-m-d') => $value]);
        $formattedTransactions = $transactions->mapWithKeys(fn($value, $key) => [\Carbon\Carbon::parse($key)->format('Y-m-d') => $value]);
    
        $dates = collect(array_merge(
            $formattedDeals->keys()->toArray(),
            $formattedPayments->keys()->toArray(),
            $formattedInvoices->keys()->toArray(),
            $formattedTransactions->keys()->toArray()
        ))->unique()->sort()->values()->toArray();
    

        return view('customers.profile', compact('customer', 'totalDealValue', 'outstandingBalance', 'formattedDeals', 'formattedPayments', 'formattedInvoices', 'formattedTransactions', 'dates'));
    }
}
