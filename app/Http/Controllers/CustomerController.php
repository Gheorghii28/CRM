<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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

    /**
     * Show the application customers.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $query = Customer::orderBy('created_at', 'asc');

        $customers = $query->paginate(20);

        return view('customers', ['customers'=> $customers]);
    }

    public function search(Request $request) {

        $query = Customer::orderBy('created_at', 'asc');

        $search = $request->input('search');

        if($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        }

        $customers = $query->paginate(20)->appends(['search' => $search]);

        return view('customers', ['customers'=> $customers, 'search' => $search]);
        
    }
}
