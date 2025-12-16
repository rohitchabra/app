<x-layout>
    <h1 class="text-xl font-bold mb-4">Create Role</h1>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <input type="text" name="name" class="border p-2 w-full mb-4" placeholder="Role Name">

        <h3 class="font-semibold mb-2">Permissions</h3>
        <div class="grid grid-cols-3 gap-2">
            @foreach ($permissions as $permission)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                    {{ $permission->name }}
                </label>
            @endforeach
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded mt-4">Save</button>
    </form>
</x-layout>
