<?php

// namespace App\Http\Controllers;

// use App\Models\Customer;
// use App\Models\Job;
// use App\Models\Trade;
// use Illuminate\Routing\Controllers\HasMiddleware;
// use Illuminate\Routing\Controllers\Middleware; 

// class DashboardController extends Controller implements HasMiddleware
// {
//     public static function middleware(): array
//     {
//         return  [
//             new Middleware('permission:view dashboard', only: ['index']),
//             new Middleware('permission:edit dashboard', only: ['edit']),
//             new Middleware('permission:create dashboard', only: ['create']),
//             new Middleware('permission:delete dashboard', only: ['destroy'])
//         ];
//     }

//     public function index()
//     {
//         $totalCustomers = Customer::has('jobs')->count();
//         $totalJobs = Customer::whereHas('jobs', function ($q) {
//             $q->where('status', 'active');
//         })->count();
//         $totalUsers = Customer::whereMonth('created_at', now()->month)
//         ->whereYear('created_at', now()->year)
//         ->count();
//         return view('dashboard.index', compact('totalCustomers', 'totalJobs', 'totalUsers'));

//     }
// }

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Job;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view dashboard', only: ['index']),
        ];
    }

    public function index()
    {
        // Total customers who have at least one job
        $totalCustomers = Customer::has('jobs')->count();

        // Total active jobs
        $totalJobs = Job::where('status', 'active')->count();

        // Total users created this month
        $totalUsers = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('dashboard.index', compact(
            'totalCustomers',
            'totalJobs',
            'totalUsers'
        ));
    }
}

