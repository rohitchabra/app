<x-layout>
    <x-slot name="heading">
        Edit User
    </x-slot>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text"
                   name="name"
                   value="{{ $user->name }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   value="{{ $user->email }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Roles</label>
            @foreach ($roles as $role)
                <div>
                    <input type="checkbox"
                           name="roles[]"
                           value="{{ $role->name }}"
                           {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    {{ $role->name }}
                </div>
            @endforeach
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </form>
</x-layout>
