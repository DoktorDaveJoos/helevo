<?php

use App\Http\Controllers\VoucherController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [VoucherController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [VoucherController::class, 'create'])->name('dashboard.create');
    Route::put('/dashboard/{id}', [VoucherController::class, 'update'])->name('dashboard.update');
    Route::put('/dashboard/{id}/cash', [VoucherController::class, 'cash'])->name('dashboard.cash');
});
