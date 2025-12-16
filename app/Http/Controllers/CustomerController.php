<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\CustomerStoreRequest;
use Illuminate\Http\Request;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('jobs')->orderBy('name');

        if ($request->title) {

            $search = $request->title;
    
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function store(CustomerStoreRequest $request)
    {
        $customer = Customer::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully',
            'customer' => $customer,
        ]);
    }

    public function edit(Customer $customer)
    {
        return response()->json($customer);
    }

    public function update(CustomerStoreRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        // If AJAX/JSON request, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully',
                'customer' => $customer,
            ]);
        }

        // fallback for non-ajax form submissions
        return back()->with('success', 'Customer updated!');
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return back()->with('success', 'Customer deleted!');
    }

    public function export()
    {
        //return Excel::download(new CustomersExport, 'customers.xlsx');
    }
}

