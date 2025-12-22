<x-layout>
    <x-slot:heading>
        Create Job
    </x-slot:heading>

<form id="jobForm" action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" novalidate>
    @csrf
        <div  class="mb-4">
            <label class="block font-semibold">Customer</label>
            <select name="customer_id" id="customer_id" class="w-full border p-2 rounded">
                <option value="">-- Select customer --</option>

                @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }} ({{ $c->email ?? 'no email' }})
                    </option>
                @endforeach
            </select>

            @error('customer_id')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Job Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border p-2 rounded">
            
            @error('title')
                <p id="title_error" class="text-red-600 text-sm error-text">{{ $message }}</p>
            @enderror       
            
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Description</label>
            <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description') }}</textarea>

              
            
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium">Select Trades</label>
            <select name="trade_ids[]" multiple class="border p-2 w-full rounded">
                @foreach($trades as $trade)
                    <option value="{{ $trade->id }}">
                        {{ $trade->name }}
                    </option>
                @endforeach
            </select>

            
           
        </div>

        <div>
            <label class="block font-semibold">Job Photos</label>
            <input type="file" name="photos[]" multiple class="w-full">

           <p id="photos_error" class="text-red-600 text-sm error-text"></p>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Save Job
        </button>
    </form>

    @vite([ 'resources/views/jobs/js/job-form.js'])

</x-layout>
