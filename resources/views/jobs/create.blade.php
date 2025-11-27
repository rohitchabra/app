<x-layout>
    <x-slot:heading>
        Create Job
    </x-slot:heading>
    

    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Customer</label>
            <select name="customer_id" id="customer_id" style="border: 0.5px solid gray;" required>
                <option value="">-- Select customer --</option>
                @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }} ({{ $c->email ?? 'no email' }})
                    </option>
                @endforeach
            </select>
            @error('customer_id')<div>{{ $message }}</div>@enderror
        </div>

        <!-- Job Title -->
        <div>
            <label class="block font-semibold">Job Title</label>
            <input 
                type="text" 
                name="title" 
                class="w-full border p-2 rounded" style="border: 0.5px solid gray;"
                value="{{ old('title') }}"
            >
            @error('title')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Job Description -->
        <div>
            <label class="block font-semibold">Description</label>
            <textarea
                name="description"
                rows="4"
                class="w-full border p-2 rounded" style="border: 0.5px solid gray;"
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Upload Photos -->
        <div>
            <label class="block font-semibold">Job Photos</label>
            <input 
                type="file" 
                name="photos[]" 
                multiple
                class="w-full" style="border: 0.5px solid gray;"
            >
            @error('photos')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded"
        >
            Save Job
        </button>

    </form>

</x-layout>
