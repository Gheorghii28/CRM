<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class InboxController extends Controller
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
        $user = User::find(auth()->user()->id);
        $tasks = $user->tasks()->with(['deal'])->where('status', 'to-do')->get();
        $reports = $user->reports()->where('status', 'Draft')->get();
        $notes = $user->notes()->with(['customer', 'deal'])->get();
        $activities = $user->activities()->with(['customer', 'deal'])->get();
        $inbox = [
            'tasks' => $tasks,
            'reports' => $reports,
            'notes' => $notes,
            'activities' => $activities
        ];

        return view('inbox.index', compact('user', 'inbox'));
    }
}
