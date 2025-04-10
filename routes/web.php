<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;

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

Route::get('/login/guest', [App\Http\Controllers\Auth\GuestLoginController::class, 'login'])->name('guest.login');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('index');
    Route::get('/fetch-statistics', [DashboardController::class,'fetchStatistics'])->name('fetch-statistics');
    Route::get('/fetch-financials', [DashboardController::class,'fetchFinancials'])->name('fetch-financials');
    Route::get('/fetch-activities', [DashboardController::class,'fetchActivities'])->name('fetch-activities');
    Route::get('/{nr}/latest-activities', [DashboardController::class,'getLatestActivities'])->name('latest-activities');
    Route::get('/fetch-reports', [DashboardController::class,'fetchReports'])->name('fetch-reports');
    Route::get('/fetch-notes', [DashboardController::class,'fetchNotes'])->name('fetch-notes');
    Route::get('/{nr}/latest-notes', [DashboardController::class,'getLatestNotes'])->name('latest-notes');
    Route::get('/fetch-tasks', [DashboardController::class,'fetchTasks'])->name('fetch-tasks');
    Route::get('/{nr}/latest-tasks', [DashboardController::class,'getLatestTasks'])->name('latest-tasks');
});

Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class,'index'])->name('index');
    Route::get('/view-pdf', [PDFController::class,'generateCustomersPDFForViewing'])->name('view-pdf');
    Route::get('/download-pdf', [PDFController::class,'generateCustomersPDFForDownload'])->name('download-pdf');
    Route::get('/search', [CustomerController::class,'search'])->name('search');
    Route::get('/{customerId}/get', [CustomerController::class,'getCustomer'])->name('get-customer');
    Route::post('/', [CustomerController::class,'store'])->name('store');
    Route::put('/{customerId}/{activityId?}', [CustomerController::class,'update'])->name('update');
    Route::delete('/{customerId}', [CustomerController::class,'destroy'])->name('destroy');
    Route::get('/{customerId}/profile', [CustomerController::class,'showProfile'])->name('show-profile');
});

Route::prefix('activities')->name('activities.')->group(function () {
    Route::get('/', [ActivityController::class,'index'])->name('index');
    Route::get('/search', [ActivityController::class,'search'])->name('search');
    Route::get('/{activityId}/show-details', [ActivityController::class,'showDetails'])->name('show-details');
    Route::get('/{activityId}/get', [ActivityController::class,'getActivity'])->name('get-activity');
    Route::get('/{activityId}/view-pdf', [PDFController::class,'generateActivityPDFForViewing'])->name('view-pdf');
    Route::get('/{activityId}/download-pdf', [PDFController::class,'generateActivityPDFForDownload'])->name('download-pdf');
    Route::get('/{year}/{month}', [ActivityController::class,'getActivitiesForMonth'])->name('calendar');
    Route::post('/', [ActivityController::class,'store'])->name('store');
    Route::put('/{activityId}', [ActivityController::class,'update'])->name('update');
    Route::delete('/{activityId}', [ActivityController::class,'destroy'])->name('destroy');
});

Route::prefix('kanban')->name('kanban.')->group(function () {
    Route::get('/', [TaskController::class,'index'])->name('index');
    Route::post('/update-kanban', [TaskController::class,'updateKanban'])->name('update-kanban');
    Route::get('/{taskId}/get', [TaskController::class,'getTask'])->name('get-task');
    Route::get('/order', [TaskController::class,'getOrder'])->name('get-order');
    Route::put('/{taskId}', [TaskController::class,'update'])->name('update');
    Route::delete('/{taskId}', [TaskController::class,'destroy'])->name('destroy');
    Route::post('/', [TaskController::class,'store'])->name('store');
});

Route::prefix('inbox')->name('inbox.')->group(function () {
    Route::get('/', [InboxController::class,'index'])->name('index');
});

Route::prefix('language')->name('language.')->group(function () {
    Route::post('/switch', [LanguageController::class,'switch'])->name('switch');
});