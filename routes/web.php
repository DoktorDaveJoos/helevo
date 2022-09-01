<?php

use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VoucherExcelController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/impressum', function() {
    return Inertia::render('Imprint');
});

Route::get('/datenschutz', function() {
    return Inertia::render('DataProtection');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /** User related */
    Route::get('/settings', [UserController::class, 'index'])->name('settings');
    Route::put('/settings', [UserController::class, 'update'])->name('settings.update');

    /** Voucher related */
    Route::get('/dashboard', [VoucherController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [VoucherController::class, 'create'])->name('dashboard.create');
    Route::put('/dashboard/{id}', [VoucherController::class, 'update'])->name('dashboard.update');
    Route::put('/dashboard/{id}/cash', [VoucherController::class, 'cash'])->name('dashboard.cash');

    /** Voucher export related */
    Route::get('/dashboard/export', [VoucherExcelController::class, 'export'])->name('dashboard.export');
    Route::post('/dashboard/import', [VoucherExcelController::class, 'import'])->name('dashboard.import');

    Route::get('/dashboard/report', [VoucherExcelController::class, 'report'])->name('dashboard.export');

    /** Voucher sale related */
//    Route::get('/sale', [SaleController::class, 'index'])->name('sale');
});
