<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

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


Route::get('/all-clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
});

Route::get('/storage-link', function () {
        Artisan::call('storage:link');
});

Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
Route::get('/show', [App\Http\Controllers\Admin\DashboardController::class, 'show'])->name('show');
Route::post('/store', [App\Http\Controllers\Admin\DashboardController::class, 'store'])->name('store');
Route::post('/update', [App\Http\Controllers\Admin\DashboardController::class, 'update'])->name('update');
Route::post('/destroy', [App\Http\Controllers\Admin\DashboardController::class, 'destroy'])->name('destroy');

Route::get('/report', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('report.index');
Route::get('/report/show', [App\Http\Controllers\Admin\ReportController::class, 'show'])->name('report.show');

Auth::routes();

