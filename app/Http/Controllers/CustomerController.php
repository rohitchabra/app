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

    public function show(Customer $customer)
    {
        // Return JSON for AJAX fetch (so edit can fetch the single customer)
        if (request()->expectsJson()) {
            return response()->json($customer);
        }
        return view('customers.show', compact('customer'));
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return back()->with('success', 'Customer deleted!');
    }
}

