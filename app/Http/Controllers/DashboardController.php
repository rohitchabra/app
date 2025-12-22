<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Job;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view dashboard', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        // Initialize variables to safe defaults
        $totalCustomers = 0;
        $totalJobs = 0;
        $totalUsers = 0;

        //$totalCustomers = $request->user()->can('admin-access') ? Customer::has('jobs')->count() : 0;

        $totalCustomers = Customer::has('jobs')->count();
        $totalJobs = Job::where('status', 'pending')->count();
        $totalUsers = $request->user()->can('admin-access') ? User::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count() : 0; 

                              //dd($totalCustomers);
        return view('dashboard.index', compact(
            'totalCustomers',
            'totalJobs',
            'totalUsers'
        ));
    }

}

