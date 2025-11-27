<x-layout>
    <x-slot:heading>
        Job Details
    </x-slot:heading>


    {{-- <div class="container">
    <h1>{{ $job->title }}</h1>
    <p>Customer: <a href="{{ route('customers.show', $job->customer) }}">{{ $job->customer->name }}</a></p>
    <p>{{ $job->description }}</p>

    <h3>Photos</h3>
    <div class="grid">
        @foreach($job->photos as $photo)
            <div class="photo-card">
                <img src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->filename }}" style="max-width:200px;">
                <form action="{{ route('jobs.photos.destroy', ['job' => $job->id, 'photo' => $photo->id]) }}" method="POST" onsubmit="return confirm('Delete photo?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </div>
        @endforeach
    </div>
</div> --}}

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
