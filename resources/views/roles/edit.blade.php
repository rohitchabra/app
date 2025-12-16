<x-layout>
    <h1 class="text-xl font-bold mb-4">Edit Role</h1>

    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name" class="border p-2 w-full mb-4"
               value="{{ $role->name }}">

        <h3 class="font-semibold mb-2">Permissions</h3>
        <div class="grid grid-cols-3 gap-2">
            @foreach ($permissions as $permission)
                <label class="flex items-center gap-2">
                    <input type="checkbox" 
                           name="permissions[]" 
                           value="{{ $permission->id }}"
                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                    {{ $permission->name }}
                </label>
            @endforeach
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded mt-4">Update</button>
    </form>
</x-layout>
