<x-layout>
    <x-slot name="heading">
        Create User
    </x-slot>

  <form method="POST" action="{{ route('users.store') }}">
    @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        @error('name')
                <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        @error('email')
                <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        @error('password')
                <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror

        <div class="mb-3">
            <label>Roles</label>
            @foreach ($roles as $role)
                <input type="checkbox" name="roles[]" value="{{ $role->name }}">
                {{ $role->name }}
            @endforeach
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </form>
</x-layout>
