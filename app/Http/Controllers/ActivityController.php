<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\User;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected $activityService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivityService $activityService)
    {
        $this->middleware('auth');
        $this->activityService = $activityService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Activity::orderBy('date', 'asc');

        $activities = $query->paginate(10);
        $activityTypeCounts = $this->activityService->getActivityTypeCounts();
        $users = User::all(['id', 'name']);
        $customers = Customer::all(['id', 'firstname', 'lastname']);
        $deals = Deal::all(['id', 'deal_name']);

        return view('activities.index', compact('activities', 'activityTypeCounts', 'users', 'customers','deals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateActivity($request);

        try {
            $activity = Activity::create($validated);
            
            return redirect()->route('activities.index')
                ->with('success', `Activity created successfully.`);
        } catch (\Exception $e) {
        
            return redirect()->route('activities.index')
                ->withErrors(['error' => 'Failed to create activity: ' . $e->getMessage()]);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $this->validateActivity($request);
    
        try {
            $activity = Activity::findOrFail($id);
            $activity->update($validated);

            $redirectRoute = $request->input('redirect_to') === 'activities.show-details' 
            ? route('activities.show-details', $activity->id)
            : route('activities.index');
    
            return redirect($redirectRoute)
            ->with('success', `Activity updated successfully.`);        
        } catch (\Exception $e) {
            return redirect()->route('activities.index')
                ->withErrors(['error' => 'Failed to update activity: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->delete();
            
            return redirect()->route('activities.index')
                ->with('success', "Activity deleted successfully.");
        } catch (\Exception $e) {
            return redirect()->route('activities.index')
                ->withErrors(['error' => 'Failed to delete activity: ' . $e->getMessage()]);
        }
    }

    /**
    * Retrieve the activity data by ID.
    */
    public function getActivity(string $id)
    {
      $activity = Activity::find($id);
      
      return response()->json($activity);
    }
    
    public function search(Request $request) {
        $search = $request->input('search');
        $ids = $request->input('ids');

        if ($ids) {
            $idsArray = explode(',', $ids);
            $activities = Activity::whereIn('id', $idsArray)->orderBy('date', 'asc')->paginate(10);
        } else {
            $query = $this->activityService->searchActivities($search);
            $activities = $query->paginate(10)->appends(['search' => $search]);
        }

        $activityTypeCounts = $this->activityService->getActivityTypeCounts();
        $users = User::all(['id', 'name']);
        $customers = Customer::all(['id', 'firstname', 'lastname']);
        $deals = Deal::all(['id', 'deal_name']);

        return view('activities.index', compact('activities', 'search', 'activityTypeCounts', 'users', 'customers','deals'));   
    }

    public function getActivitiesForMonth($year, $month)
    {
        $activities = Activity::whereYear('date', $year)
                              ->whereMonth('date', $month)
                              ->orderBy('date', 'asc')
                              ->get();

        return response()->json($activities);
    }

    private function validateActivity(Request $request) 
    {
        return $request->validate([
            'user_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:customers,id',
            'activity_type' => 'required|max:255',
            'activity_description' => 'nullable|max:1000',
            'date' => 'required|date',
            'status' => 'required|in:planned,completed,canceled',
            'priority' => 'required|in:low,medium,high',
            'deal_id' => 'nullable|exists:deals,id',
            'location' => 'nullable|max:255',
            'outcome' => 'nullable|max:1000',
            'notes' => 'nullable|max:2000',
            'reminder' => 'nullable|date',
        ]);
    }

}
