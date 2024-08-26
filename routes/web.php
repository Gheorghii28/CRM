<?php

use App\Http\Controllers\CustomerController;
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
    Route::get('/', [CustomerController::class,'index'])->name('customers');
    Route::get('/search', [CustomerController::class,'search'])->name('search');
});
