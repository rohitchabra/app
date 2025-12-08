<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\CustomerStoreRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(10);
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

    public function jobs(Customer $customer)
    {
        $customer->load(['jobs.trades', 'jobs.photos']);
        return view('customers.modals.partials.jobs-list', compact('customer'));
    }
}

