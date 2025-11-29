<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>

    <a href="{{ route('jobs.create') }}" 
        class="bg-green-600 text-white px-4 py-2 rounded inline-block mb-4">
        + Add Job
    </a>

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="py-2 px-4 text-left">Job Title</th>
                <th class="py-2 px-4 text-left">Customer</th>
                <th class="py-2 px-4 text-left">Photos</th>
                <th class="py-2 px-4 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($jobs as $job)
                <tr class="border-b">
                    <!-- Job Title -->
                    <td class="py-2 px-4">{{ $job->title }}</td>

                    <!-- Customer Name -->
                    <td class="py-2 px-4">{{ $job->customer->name }}</td>

                    <!-- Photos Preview -->
                    <td class="py-2 px-4">
                        <div class="flex space-x-2">
                            @foreach($job->photos->take(3) as $photo)
                                <img 
                                    src="{{ asset('storage/' . $photo->path) }}"
                                    class="w-16 h-16 object-cover rounded border"
                                >
                            @endforeach

                            @if($job->photos->count() > 3)
                                <span class="text-sm text-gray-600">
                                    +{{ $job->photos->count() - 3 }} more
                                </span>
                            @endif
                        </div>
                    </td>

                    <!-- Actions -->
                    <td class="py-2 px-4">
                        <a href="{{ route('jobs.show', $job->id) }}" 
                           class="bg-blue-600 text-white px-3 py-1 rounded mr-2">
                            View
                        </a>

                        <a href="{{ route('jobs.edit', $job->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded mr-2">
                            Edit
                        </a>

                        <form action="{{ route('jobs.destroy', $job->id) }}" 
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button 
                                class="bg-red-600 text-white px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>


{{-- <x-layout>
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
</x-layout> --}}


