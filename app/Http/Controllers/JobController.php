<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Models\Customer;
use App\Models\Job;
use App\Models\JobPhoto;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JobsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class JobController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return  [
            new Middleware('permission:view jobs', only: ['index']),
            new Middleware('permission:edit jobs', only: ['edit']),
            new Middleware('permission:create jobs', only: ['create']),
            new Middleware('permission:delete jobs', only: ['destroy'])
        ];
    }

    public function show()
    {
        return Excel::download(new JobsExport, 'jobs.xlsx');
    }

    public function exportPdf()
    {
        $jobs = Job::all();

        $pdf = Pdf::loadView('jobs.pdf', compact('jobs'));

        return $pdf->download('jobs.pdf');
    }

    public function index(Request $request)
    {
        $customers = Customer::orderBy('name')->get();

        $selectedCustomer = null;
        if ($request->customer_id) {
            //dd('11');
            $selectedCustomer = Customer::find($request->customer_id);
        }

        // Jobs with filter
        $jobs = Job::with(['customer', 'photos', 'trades'])
            ->when($request->customer_id, function ($q) use ($request) {
                $q->where('customer_id', $request->customer_id);
            })
            ->latest()
            ->withCount('photos')
            ->paginate(15)
            ->withQueryString(); // keep ?customer_id=value on pagination
            
        return view('jobs.index', compact('customers', 'jobs'));
    }

    public function create()
    {
        //dd('11');
        $customers = Customer::orderBy('name')->get();
        $trades = Trade::orderBy('name')->get();

        return view('jobs.create', compact('customers', 'trades'));
    }

    public function store(StoreJobRequest $request)
    {
        //dd($request);
        DB::beginTransaction();

        try {
            $job = Job::create([
                'customer_id' => $request->customer_id,
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if ($request->trade_ids) {
                $job->trades()->sync($request->trade_ids);
            }

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $path = $file->store('jobs/'.$job->id, 'public');

                    $job->photos()->create([
                        'path' => $path,
                        'filename' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('jobs.index', $job)
                ->with('success', 'Job created.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->withErrors([
                'error' => 'Failed to create job: '.$e->getMessage(),
            ]);
        }
    }

    public function photo(Job $job)
    {
        $job->load(['customer', 'photos', 'trades']);
        return view('jobs.show', compact('job'));
    }


    public function edit(Job $job)
    {
        $customers = Customer::orderBy('name')->get();
        $trades = Trade::orderBy('name')->get();

        return view('jobs.edit', compact('job', 'customers', 'trades'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',

            'trade_ids'   => 'required|array',
            'trade_ids.*' => 'exists:trades,id',

            'photos'      => 'nullable|array|max:5',
            'photos.*'    => 'image|max:5120', // 5MB each
        ]);

        DB::beginTransaction();

        try {
            // Update job
            $job->update([
                'customer_id' => $validated['customer_id'],
                'title'       => $validated['title'],
                'description' => $validated['description'] ?? null,
            ]);

            // Sync trades
            $job->trades()->sync($validated['trade_ids']);

            // Store new photos (optional)
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $path = $file->store("jobs/{$job->id}", 'public');

                    $job->photos()->create([
                        'path'     => $path,
                        'filename' => $file->getClientOriginalName(),
                        'mime'     => $file->getClientMimeType(),
                        'size'     => $file->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('jobs.index')
                ->with('success', 'Job updated successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Failed to update job: ' . $e->getMessage()
                ]);
        }
    }


    public function update1(Request $request, Job $job)
    {
        dd('index jobs');
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photos.*' => 'nullable|image|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $job->update([
                'customer_id' => $validated['customer_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
            ]);

            if ($request->trade_ids) {
                $job->trades()->sync($request->trade_ids);
            }

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $path = $file->store('jobs/'.$job->id, 'public');
                    $job->photos()->create([
                        'path' => $path,
                        'filename' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('jobs.index', $job)->with('success', 'Job updated.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => 'Failed to update job: '.$e->getMessage()]);
        }
    }

    public function destroy(Job $job)
    {
        // Deleting the job will cascade-delete job_photos (DB onDelete cascade).
        // But we should also remove files from storage.
        foreach ($job->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted.');
    }
}
