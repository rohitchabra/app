<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>
    <div class="grid grid-cols-3 gap-4 p-4">
        @can('view customers')
            <div class="bg-white shadow-md rounded-xl p-6 text-center">
                <h2 class="text-gray-500">Total Customers</h2>
                <p class="text-2xl font-bold">{{ $totalCustomers }}</p>
            </div>
        @endcan
        @can('view jobs')
            <div class="bg-white shadow-md rounded-xl p-6 text-center">
                <h2 class="text-gray-500">Total Jobs</h2>
                <p class="text-2xl font-bold">{{ $totalJobs }}</p>
            </div>
        @endcan
        @can('view users')
            <div class="bg-white shadow-md rounded-xl p-6 text-center">
                <h2 class="text-gray-500">Total Users</h2>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            </div>
        @endcan
    </div>
    {{-- @for ($i = 0; $i < 3; $i++)
        <div class="p-4 mb-4 bg-white rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Card {{ $i + 1 }}</h2>
            <p>This is the content of card {{ $i + 1 }}.</p>
        </div>
    @endfor --}}

    {{-- @foreach ($products as $product)
        <div class="p-4 mb-4 bg-white rounded shadow">
            <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
        </div>
        
        
    @endforeach --}}

    {{-- <span class="d-block p-2 bg-primary text-white">d-block</span>
    <span class="d-block p-2 bg-dark text-white">d-block</span>

    <span class="d-line p-2 bg-primary text-white">d-block</span>
    <span class="d-line p-2 bg-dark text-white">d-block</span> --}}

</x-layout>
