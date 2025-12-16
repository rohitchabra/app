<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>

    @if (session('error'))
        <p class="text-danger alert alert-danger" role="alert" id="message">
            {{ session('error') }}
        </p>
    @endif
    @if (session('success'))
        <p class="text-danger alert alert-danger" role="alert" id="message">
            {{ session('success') }}
        </p>
    @endif

     @if(auth()->user()->hasRole(['admin']))
        <a href="{{ route('trades.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            + Add Trade
        </a>
    @endauth

    {{-- @if (session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
    @endif --}}
    {{-- @if (session('error'))
        <p class="text-green-600 mb-4">{{ session('error') }}</p>
    @endif --}}

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Trades</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($trades as $trade)
                <tr>
                    <td class="border px-4 py-2">{{ $trade->id }}</td>
                    <td class="border px-4 py-2">{{ $trade->name }}</td>
                    <td class="border px-4 py-2">{{ $trade->trade_id }}</td>
                    <td class="border px-4 py-2">
                        {{-- || auth()->id() == 3 --}}
                        @if(auth()->user()->hasRole(['admin']))
                        {{-- @if($trade->trade_id == 'custom') --}}
                            <a href="{{ route('trades.edit', $trade->id) }}"
                            class="text-blue-600 mr-2">Edit</a>

                            <form action="{{ route('trades.destroy', $trade->id) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600"
                                        onclick="return confirm('Delete trade?')">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>