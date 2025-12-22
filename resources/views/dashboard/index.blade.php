<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>
    <h1>Total Customers: {{ $totalCustomers }}</h1>
    <h1>Total Jobs: {{ $totalJobs }}</h1>
    <h1>Total Users: {{ $totalUsers }}</h1>
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
