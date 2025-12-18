<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Http\Requests\CustomerStoreRequest;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; 

class CustomerController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return  [
            new Middleware('permission:view customers', only: ['index']),
            new Middleware('permission:edit customers', only: ['edit']),
            new Middleware('permission:create customers', only: ['create']),
            new Middleware('permission:delete customers', only: ['destroy'])
        ];
    }

    public function show()
    {
        return Excel::download(
            new CustomersExport,
            'customers.xlsx'
        );
    }

    public function exportPdf()
    {
        $customers = Customer::orderBy('name')->get();

        $pdf = Pdf::loadView('customers.pdf', compact('customers'));

        return $pdf->download('customers.pdf');
    }

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
}
