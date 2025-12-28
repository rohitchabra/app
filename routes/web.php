<?php

use App\Http\Controllers\Auth\RegisteredController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\UserController;
use App\Models\Job;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPhotoController;
use App\Http\Controllers\PhotoController;

Route::resource('users', UserController::class);
Route::resource('customers', CustomerController::class);
Route::resource('jobs', JobController::class);
Route::resource('trades', TradeController::class);
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);

Route::get('/', function () {
    return view('home');
});

Route::get('/create-test-user', [LoginController::class, 'createTestUser']);
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisteredController::class, 'show'])->name('register');
Route::post('/register', [RegisteredController::class, 'store']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/contact', function () {
    return view('contact');
});

Route::middleware('auth', 'role:admin')->group(function () {});

Route::middleware('auth')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('/customers/{customer}/jobs', [CustomerController::class, 'jobs'])->name('customers.jobs');

    Route::get('/trades', [TradeController::class, 'index'])->name('trades.index');
    Route::get('/trades/create', [TradeController::class, 'create'])->name('trades.create');
    Route::post('/trades', [TradeController::class, 'store'])->name('trades.store');
    Route::get('/trades/{trade}/edit', [TradeController::class, 'edit'])->name('trades.edit');
    Route::put('/trades/{trade}', [TradeController::class, 'update'])->name('trades.update');
    Route::delete('/trades/{trade}', [TradeController::class, 'destroy'])->name('trades.destroy');

    Route::delete('jobs/{job}/photos/{photo}', [JobController::class, 'deletePhoto'])->middleware('auth')->name('jobs.photos.destroy');

    // Job list
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

    // Create job form
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');

    // Store job
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');

    // Show job
    // Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

    // Edit job
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');

    // Update job
    Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');

    // Delete job
    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');

    Route::get('/jobs/{job}/photo', [JobController::class, 'photo'])->name('photo');

    Route::get('/jobs/export', [JobController::class, 'export'])->name('jobs.export');
    
    Route::get('/jobs/export/pdf', [JobController::class, 'exportPdf'])->name('jobs.export.pdf');

    // Route::post('/jobs/{job}/photos', [JobController::class, 'uploadPhotos'])
    // ->name('jobs.photos.upload');

    // Route::post('/photos/upload', [PhotoController::class, 'upload'])
    //  ->name('photos.upload');

    Route::post('/jobs/{job}/upload', [PhotoController::class, 'upload'])
    ->name('jobs.photos.upload');

    Route::delete('/jobs/photos/bulk-delete', [PhotoController::class, 'deletePhotos'])
    ->name('jobs.photos.bulk-delete');

    Route::get('/jobs/{job}/photo', [PhotoController::class, 'photo']);


    // Route::get('/roles', [RoleController::class, 'roles'])->name('roles');
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::get('/customers/export', [CustomerController::class, 'export'])
        ->name('customers.export');

    Route::get('/customers/export/pdf', [CustomerController::class, 'exportPdf'])
        ->name('customers.export.pdf');

});
