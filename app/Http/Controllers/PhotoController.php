<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobPhoto;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function photo(Job $job)
    {
        $job->load(['customer', 'photos', 'trades']);
        return view('jobs.partials.photos', compact('job'));
    }

    public function upload(Request $request, Job $job)
    {
        $request->validate([
            'photos.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        foreach ($request->file('photos', []) as $photo) {
            $path = $photo->store('job-photos', 'public');

            $job->photos()->create([
                'path' => $path,
            ]);
        }

        return back()->with('success', 'Selected photos uploaded successfully.');

        // $job->load(['customer', 'photos', 'trades']);

        // return redirect()
        //     ->route('jobs.show', $job)
        //     ->with('success', 'Photos uploaded successfully.');
    }


    public function deletePhotos(Request $request)
    {
        $request->validate([
            'photo_ids' => 'required|array',
        ]);

        $photos = JobPhoto::whereIn('id', $request->photo_ids)->get();

        foreach ($photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        return back()->with('success', 'Selected photos deleted');
    }
    
}

