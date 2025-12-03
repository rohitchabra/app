<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>
    <h1 class="text-2xl font-bold mb-4">Edit Trade</h1>

    <form method="POST" action="{{ route('trades.update', $trade->id) }}">
        @csrf
        @method('PUT')

        <label class="block">Name</label>
        <input type="text" name="name" value="{{ old('name', $trade->name) }}"
               class="border w-full px-2 py-1 mb-2">

        @error('name')
            <p class="text-red-600 mb-2">{{ $message }}</p>
        @enderror

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</x-layout>
