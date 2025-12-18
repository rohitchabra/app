<x-layout>
    <x-slot name="heading">
        Users
    </x-slot>
    {{-- @if(auth()->user()->hasRole(['admin'])) --}}
    @can('view users')
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
            Create User
        </a>
    @endcan
    {{-- @endauth --}}

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Created</th>
                <th width="200">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td class="p-3 flex gap-2">
                        @can('view users')
                            <a href="{{ route('users.edit', $user->id) }}"
                            class="btn btn-sm btn-warning">
                            Edit
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this user?')" class="px-3 py-1 bg-red-600 text-white rounded">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
