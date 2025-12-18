<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Job;
use App\Models\Trade;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; 

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return  [
            new Middleware('permission:view dashboard', only: ['index']),
            new Middleware('permission:edit dashboard', only: ['edit']),
            new Middleware('permission:create dashboard', only: ['create']),
            new Middleware('permission:delete dashboard', only: ['destroy'])
        ];
    }

    public function index()
    {
        return view('dashboard.index');
    }
}
