<x-layout>
    <h1 class="text-xl font-bold mb-4">Edit Permission</h1>

    <form action="{{ route('permissions.update', $permission) }}" method="POST"
          class="bg-white p-5 rounded shadow">
        @csrf
        @method('PUT')

        <label>Permission Name:</label>
        <input type="text" name="name"
               class="border p-2 w-full mt-2"
               value="{{ $permission->name }}">
        @error('name') <p class="text-red-600">{{ $message }}</p> @enderror

        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Update</button>
    </form>
</x-layout>
