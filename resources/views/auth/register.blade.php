<x-layout>
    <x-slot:heading>
       
    </x-slot:heading>

    <form method="POST" action="/register" class="max-w-md mx-auto mt-8 space-y-6">
        @csrf

        <div>
            <label>Name</label>
            <input name="name" class="border p-2 w-full" value="{{ old('name') }}">
            @error('name') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" class="border p-2 w-full" value="{{ old('email') }}">
            @error('email') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" class="border p-2 w-full">
            @error('password') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="border p-2 w-full">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Register
        </button>
    </form>

</x-layout>

