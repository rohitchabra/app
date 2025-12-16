<x-layout>
    <h1 class="text-2xl font-bold mb-4">Roles</h1>

    <a href="{{ route('roles.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">
        + Add Role
    </a>

    <table class="w-full mt-4 bg-white shadow rounded">
        <thead>
        <tr class="bg-gray-200 border-b">
            <th class="p-3">ID</th>
            <th class="p-3">Name</th>
            <th class="p-3">Permissions</th>
            <th class="p-3">Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($roles as $role)
            <tr class="border-b">
                <td class="p-3">{{ $role->id }}</td>
                <td class="p-3">{{ $role->name }}</td>

                <td class="p-3">
                    @foreach($role->permissions as $permission)
                        <span class="bg-gray-200 px-2 py-1 rounded text-sm">{{ $permission->name }}</span>
                    @endforeach
                </td>

                <td class="p-3 flex gap-2">
                    <a href="{{ route('roles.edit', $role) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>

                    <form action="{{ route('roles.destroy', $role) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete this role?')" class="px-3 py-1 bg-red-600 text-white rounded">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $roles->links() }}
    </div>
</x-layout>
