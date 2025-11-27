<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>

    <a href="{{ route('jobs.create') }}" 
        class="bg-green-600 text-white px-4 py-2 rounded inline-block mb-4">
        + Add Job
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($jobs as $job)
            <div class="border rounded-xl p-4 shadow-sm bg-white">
                
                <h2 class="text-xl font-semibold mb-1">{{ $job->title }}</h2>
                <p class="text-gray-600 mb-3">Customer: {{ $job->customer->name }}</p>


                <div class="grid grid-cols-3 gap-2 mb-3">
                    @foreach($job->photos as $photo)
                        <img 
                            src="{{ asset('storage/' . $photo->path) }}" 
                            class="w-full h-24 object-cover rounded"
                        >
                    @endforeach
                </div>

                <a href="{{ route('jobs.show', $job->id) }}"
                    class="text-blue-600 hover:underline">
                    View Details
                </a>
            </div>
        @endforeach
    </div>
</x-layout>


