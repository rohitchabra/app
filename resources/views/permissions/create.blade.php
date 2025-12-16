<x-layout>
    <h1 class="text-xl font-bold mb-4">Add Permission</h1>

    <form action="{{ route('permissions.store') }}" method="POST" class="bg-white p-5 rounded shadow">
        @csrf

        <label>Permission Name:</label>
        <input type="text" name="name" class="border p-2 w-full mt-2" value="{{ old('name') }}">
        @error('name') <p class="text-red-600">{{ $message }}</p> @enderror

        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Save</button>
    </form>
</x-layout>
