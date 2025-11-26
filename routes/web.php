<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use App\Models\Job;
use Illuminate\Contracts\Session\Session;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\RegisteredController;
use App\Http\Controllers\JobController;

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
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth')->name('dashboard');


Route::get('/contact', function () {
    return view('contact');
});

Route::middleware('guest')->group(function () {

    // Route::get('login', [LoginController::class, 'index']);
    // Route::post('login', [LoginController::class, 'store']);

    //Route::get('/register', [RegisteredUserController::class, 'create']);
    //Route::post('/register', [RegisteredUserController::class, 'store']);

});

// Route::prefix('admin')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');

//     Route::get('/add', function () {
//         return view('add');
//     })->name('add');

//     Route::get('/sub', function () {
//         return view('sub');
//     })->name('sub');
// });