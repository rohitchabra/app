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
                <th class="py-2 px-4 text-left">Trades</th>
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

                    <td class="py-2 px-4">
                        @foreach($job->trades as $trade)
                            <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded mr-1 text-sm">
                                {{ $trade->name }}
                            </span>
                        @endforeach
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


