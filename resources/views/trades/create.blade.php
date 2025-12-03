<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>
    <h1 class="text-2xl font-bold mb-4">Add Trade</h1>

    <form method="POST" action="{{ route('trades.store') }}">
        @csrf

        <label class="block">Name</label>
        <input type="text" name="name" value="{{ old('name') }}"
               class="border w-full px-2 py-1 mb-2">

        @error('name')
            <p class="text-red-600 mb-2">{{ $message }}</p>
        @enderror

        <button class="bg-green-600 text-white px-4 py-2 rounded">Create</button>
    </form>
</x-layout>
