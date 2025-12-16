<x-layout>
    <h1 class="text-2xl font-bold mb-4">Permissions</h1>

    <a href="{{ route('permissions.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">
        + Add Permission
    </a>

    <table class="w-full mt-4 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200 border-b">
                <th class="p-3 text-left">ID</th>
                <th class="p-3 text-left">Permission Name</th>
                <th class="p-3 text-left">Created</th>
                <th class="p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr class="border-b">
                    <td class="p-3">{{ $permission->id }}</td>
                    <td class="p-3">{{ $permission->name }}</td>
                    <td class="p-3">
                        {{ $permission->created_at->format('d M, Y') }}
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('permissions.edit', $permission) }}"
                           class="px-3 py-1 bg-yellow-500 text-white rounded">
                            Edit
                        </a>

                        <form method="POST" action="{{ route('permissions.destroy', $permission) }}">
                            @csrf
                            @method('DELETE')

                            <button class="px-3 py-1 bg-red-600 text-white rounded"
                                    onclick="return confirm('Delete this permission?')">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $permissions->links() }}
    </div>
</x-layout>
