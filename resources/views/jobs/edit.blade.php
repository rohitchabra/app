<x-layout>
    <x-slot:heading>
        Edit Job
    </x-slot:heading>

    <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold">Job Title</label>
            <input type="text" name="title" value="{{ $job->title }}"
                   class="border p-2 w-full rounded">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Customer</label>
            <select name="customer_id" class="border p-2 w-full rounded">
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" 
                        {{ $job->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Upload Photos</label>
            <input type="file" name="photos[]" multiple class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Existing Photos</label>
            <div class="flex space-x-2">
                @foreach($job->photos as $photo)
                    <img src="{{ asset('storage/' . $photo->path) }}" 
                        class="w-20 h-20 object-cover rounded border">
                @endforeach
            </div>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</x-layout>
