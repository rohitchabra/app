<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use App\Models\Job;
use Illuminate\Contracts\Session\Session;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\RegisteredController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\DashboardController;

Route::resource('customers', CustomerController::class);
Route::resource('jobs', JobController::class);
Route::resource('trades', TradeController::class);

Route::get('/', function () {
    return view('home');
});

Route::get('/create-test-user', [LoginController::class, 'createTestUser']);
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisteredController::class, 'show'])->name('register');
Route::post('/register', [RegisteredController::class, 'store']);

// Protected Dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard.index');
// })->middleware('auth')->name('dashboard');

// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware('auth')
//     ->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/contact', function () {
    return view('contact');
});

Route::middleware('auth')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');

    Route::get('/create', [JobController::class, 'create'])->middleware('auth')->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->middleware('auth')->name('jobs.store');
    Route::get('/jobs', [JobController::class, 'index'])->middleware('auth')->name('jobs.index');

    Route::get('/trades', [TradeController::class, 'index'])->name('trades.index');
    Route::get('/trades/create', [TradeController::class, 'create'])->name('trades.create');
    Route::post('/trades', [TradeController::class, 'store'])->name('trades.store');
    Route::get('/trades/{trade}/edit', [TradeController::class, 'edit'])->name('trades.edit');
    Route::put('/trades/{trade}', [TradeController::class, 'update'])->name('trades.update');
    Route::delete('/trades/{trade}', [TradeController::class, 'destroy'])->name('trades.destroy');

    // Route::get('/trades', [TradeController::class, 'index'])->middleware('auth')->name('trades.index');
    // Route::post('/trades', [TradeController::class, 'create'])->middleware('auth')->name('trades.create');
    // Route::post('/trades', [TradeController::class, 'edit'])->middleware('auth')->name('trades.edit');

    Route::delete('jobs/{job}/photos/{photo}', [JobController::class, 'deletePhoto'])->middleware('auth')->name('jobs.photos.destroy');

});

