<x-layout>
    <x-slot:heading>Customers</x-slot:heading>

    <button 
        class="bg-green-600 text-white px-4 py-2 rounded"
        data-bs-toggle="modal"
        data-bs-target="#addCustomerModal">
        + Add Customer
    </button>

    <div class="mt-6">
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Phone</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td class="p-2 border">{{ $customer->name }}</td>
                    <td class="p-2 border">{{ $customer->email }}</td>
                    <td class="p-2 border">{{ $customer->phone }}</td>
                    <td class="p-2 border space-x-2">

                        <!-- Edit -->
                        <button 
                            class="bg-blue-600 text-white px-2 py-1 rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#editCustomerModal{{ $customer->id }}">
                            Edit
                        </button>

                        <!-- Delete -->
                        <button 
                            class="bg-red-600 text-white px-2 py-1 rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCustomerModal{{ $customer->id }}">
                            Delete
                        </button>

                    </td>
                </tr>

                @include('customers.modals.edit', ['customer' => $customer])
                @include('customers.modals.delete', ['customer' => $customer])
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>

    {{-- Add Modal --}}
    @include('customers.modals.add')

    {{-- JS --}}
    @vite([ 'resources/views/customers/js/customer-form.js'])
    {{-- <script src="{{ asset('js/customer-form.js') }}"></script> --}}

</x-layout>



