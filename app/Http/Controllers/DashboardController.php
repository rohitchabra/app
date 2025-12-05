<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Job;
use App\Models\Trade;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function index1()
    {
        
        $totalCustomers = Customer::count();
        $totalJobs = Job::count();
        $totalTrades = Trade::count();
        //dd('here', Customer::count(), Job::count(), Trade::count());
        return view('dashboard.index', [
        ]);
    }
}
