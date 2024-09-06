<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

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
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get(['id', 'name']);
        $deals = Deal::orderBy('deal_name', 'asc')->get(['id', 'deal_name']);
        $tasks = Task::with(['user:id,name', 'deal:id,deal_name,customer_id', 'deal.customer:id,firstname,lastname'])
                ->orderBy('order')
                ->get();
                
        return view('kanban.index', compact('tasks', 'users', 'deals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateTask($request);

        try {
            $task = Task::create($validated);

            return redirect()->back()->with('success', `Task "{$task->title}" created successfully.`);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Failed to create task. Please try again: ' . $e->getMessage()]);
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
        $validated = $this->validateTask($request);
    
        try {
            $task = Task::findOrFail($id);
            $task->update($validated);

            return redirect()->back()->with('success', `Task "{$task->title}" updated successfully.`);     
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update task: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            
            return redirect()->back()->with('success', `Task "{$task->title}" deleted successfully.`); 
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete task: ' . $e->getMessage()]);
        }
    }

    public function updateKanban(Request $request)
    {
        $task = Task::find($request->input('id'));
        $task->status = $request->input('status');

        // Update order for tasks in the new status
        $order = $request->input('order');
        foreach ($order as $index => $id) {
            $t = Task::find($id);
            $t->order = $index;
            $t->save();
        }

        $task->save();

        return response()->json(['status' => 'success']);
    } 
    
    /**
    * Retrieve the task data by ID.
    */
    public function getTask($id) 
    {
      $task = Task::find($id);
      
      return response()->json($task);
    }

    /**
    * Retrieve the order data by status.
    */
    public function getOrder(Request $request)
    {
        $status = $request->query('status');
        $lastOrder = Task::where('status', $status)->max('order');
        $newOrder = is_null($lastOrder) ? 0 : $lastOrder + 1;

        return response()->json($newOrder);
    }

    private function validateTask(Request $request) 
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'task_description' => 'required|string',
            'due_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'deal_id' => 'nullable|exists:deals,id',
            'status' => 'required|in:to-do,in-progress,done',
            'order'=> 'required|numeric',
        ]);
    }
}
