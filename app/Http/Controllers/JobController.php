<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Customer;
use App\Models\JobPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index()
    {
        // dd('index jobs');
        // eager load customer and photos
        $jobs = Job::with(['customer','photos'])->paginate(15);
        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        //dd('index jobs');
        // pass customers list to select which customer owns the job
        $customers = Customer::orderBy('name')->get();
        return view('jobs.create', compact('customers'));
        //return view('jobs.create');
    }

    public function store(Request $request)
    {
        //dd('index jobs');
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photos.*' => 'nullable|image|max:5120', // each file max 5MB
        ]);

        DB::beginTransaction();
        try {
            $job = Job::create([
                'customer_id' => $validated['customer_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
            ]);

            // handle multiple photos
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $path = $file->store('jobs/'.$job->id, 'public'); // e.g. jobs/1/abc.jpg

                    $job->photos()->create([
                        'path' => $path,
                        'filename' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('jobs.show', $job)->with('success','Job created.');
        } catch (\Throwable $e) {
            DB::rollBack();
            // optionally delete files already stored if any
            return back()->withInput()->withErrors(['error' => 'Failed to create job: '.$e->getMessage()]);
        }
    }

    public function show(Job $job)
    {
        //dd('index jobs');
        $job->load(['customer','photos']);
        return view('jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        dd('edit job');
        $customers = Customer::orderBy('name')->get();
        $job->load('photos');
        return view('jobs.edit', compact('job','customers'));
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
            return redirect()->route('jobs.show', $job)->with('success','Job updated.');
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
        return redirect()->route('jobs.index')->with('success','Job deleted.');
    }

    // Optional: method to delete a single photo
    public function deletePhoto(Job $job, JobPhoto $photo)
    {
        if ($photo->job_id !== $job->id) {
            abort(404);
        }
        Storage::disk('public')->delete($photo->path);
        $photo->delete();
        return back()->with('success','Photo removed.');
    }
}
