<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// General handling for all unregistered routes
Route::get('{any}', function () {
    $route = Auth::check() ? RouteServiceProvider::HOME : RouteServiceProvider::LOGIN;
    return redirect($route);
})->where('any', '.*')->name('default');

// Route to show the report generation form
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

// Route to handle report generation form submission
Route::post('/generate-report', [ReportController::class, 'generate'])->name('report.generate');
