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

class JobController extends Controller
{
    public function index1()
    {
        $customers = Customer::orderBy('name')->get();
            
        $jobs = Job::with(['customer', 'photos', 'trades'])->latest()->paginate(15);

        return view('jobs.index', compact('customers', 'jobs'));
    }

    public function index(Request $request)
    {
        $customers = Customer::orderBy('name')->get();

        $selectedCustomer = null;
        if ($request->customer_id) {
            $selectedCustomer = Customer::find($request->customer_id);
        }

        // Jobs with filter
        $jobs = Job::with(['customer', 'photos', 'trades'])
            ->when($request->customer_id, function ($q) use ($request) {
                $q->where('customer_id', $request->customer_id);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString(); // keep ?customer_id=value on pagination

        return view('jobs.index', compact('customers', 'jobs'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $trades = Trade::orderBy('name')->get();

        return view('jobs.create', compact('customers', 'trades'));
    }

    public function store(StoreJobRequest $request)
    {
        // dd($request);
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

            return redirect()->route('jobs.show', $job)
                ->with('success', 'Job created.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->withErrors([
                'error' => 'Failed to create job: '.$e->getMessage(),
            ]);
        }
    }

    public function show(Job $job)
    {
        // dd('index jobs');
        //$job->load(['customer', 'photos', 'trades']);

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

    // Optional: method to delete a single photo
    // public function deletePhoto(Job $job, JobPhoto $photo)
    // {
    //     if ($photo->job_id !== $job->id) {
    //         abort(404);
    //     }
    //     Storage::disk('public')->delete($photo->path);
    //     $photo->delete();
    //     return back()->with('success','Photo removed.');
    // }
}
