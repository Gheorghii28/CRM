<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
        $tasks = Task::with(['user:id,name', 'deal:id,deal_name,customer_id', 'deal.customer:id,firstname,lastname'])
                ->orderBy('order')
                ->get();

        return view("kanban.index", compact("tasks"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
}
