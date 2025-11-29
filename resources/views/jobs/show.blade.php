<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>

    <div class="space-y-4">

        <!-- Job Title -->
        <h2 class="text-xl font-bold">{{ $job->title }}</h2>

        <!-- Job Description -->
        <p class="text-gray-700">
            {{ $job->description }}
        </p>

        <!-- Photos -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            @foreach ($job->photos as $photo)
                <div class="border rounded p-2">
                    <img 
                        src="{{ asset('storage/' . $photo->path) }}" 
                        alt="Job Photo"
                        class="w-full h-40 object-cover rounded"
                    >
                </div>
            @endforeach
        </div>

        @if ($job->photos->isEmpty())
            <p class="text-gray-500">No photos uploaded for this job.</p>
        @endif

        <!-- Back Button -->
        <a 
            href="{{ route('jobs.index') }}" 
            class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded"
        >
            Back to Jobs
        </a>

    </div>

</x-layout>
