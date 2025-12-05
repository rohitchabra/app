<x-layout>
    <x-slot:heading>
        
    </x-slot:heading>

    @for ($i = 0; $i < 3; $i++)
        <div class="p-4 mb-4 bg-white rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Card {{ $i + 1 }}</h2>
            <p>This is the content of card {{ $i + 1 }}.</p>
        </div>
    @endfor

    {{-- @foreach ($products as $product)
        <div class="p-4 mb-4 bg-white rounded shadow">
            <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
        </div>
        
        
    @endforeach --}}
</x-layout>
