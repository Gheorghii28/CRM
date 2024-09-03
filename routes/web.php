<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('index');
    Route::get('/fetch-statistics', [DashboardController::class,'fetchStatistics'])->name('fetch-statistics');
    Route::get('/fetch-financials', [DashboardController::class,'fetchFinancials'])->name('fetch-financials');
    Route::get('/fetch-activities', [DashboardController::class,'fetchActivities'])->name('fetch-activities');
    Route::get('/fetch-reports', [DashboardController::class,'fetchReports'])->name('fetch-reports');
    Route::get('/fetch-notes', [DashboardController::class,'fetchNotes'])->name('fetch-notes');
    Route::get('/fetch-tasks', [DashboardController::class,'fetchTasks'])->name('fetch-tasks');
});

Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class,'index'])->name('index');
    Route::get('/search', [CustomerController::class,'search'])->name('search');
    Route::get('/{customerId}/get', [CustomerController::class,'getCustomer'])->name('get-customer');
    Route::post('/', [CustomerController::class,'store'])->name('store');
    Route::put('/{customerId}', [CustomerController::class,'update'])->name('update');
    Route::delete('/{customerId}', [CustomerController::class,'destroy'])->name('destroy');
    Route::get('/{customerId}/profile', [CustomerController::class,'showProfile'])->name('show-profile');
});

Route::prefix('activities')->name('activities.')->group(function () {
    Route::get('/', [ActivityController::class,'index'])->name('index');
    Route::get('/search', [ActivityController::class,'search'])->name('search');
    Route::get('/{activityId}/get', [ActivityController::class,'getActivity'])->name('get-activity');
    Route::get('/{year}/{month}', [ActivityController::class,'getActivitiesForMonth'])->name('calendar');
    Route::get('/{activityId}/details', [ActivityController::class,'showDetails'])->name('show-details');
    Route::get('/options-dinamically', [ActivityController::class,'getOptionsDinamically'])->name('options-dinamically');
    Route::post('/', [ActivityController::class,'store'])->name('store');
    Route::put('/{activityId}', [ActivityController::class,'update'])->name('update');
    Route::delete('/{activityId}', [ActivityController::class,'destroy'])->name('destroy');
});

Route::prefix('kanban')->name('kanban.')->group(function () {
    Route::get('/', [TaskController::class,'index'])->name('index');
    Route::post('/update-kanban', [TaskController::class,'updateKanban'])->name('update-kanban');
});