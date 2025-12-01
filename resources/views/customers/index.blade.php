<x-layout>
    <x-slot:heading>Customers</x-slot:heading>

<button type="button" class="btn btn-success" 
        onclick="openCustomerModal('add')">Add New Customer</button>

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
                        <button type="button" class="btn btn-primary" onclick="openCustomerModal('edit', {{ $customer->id }})">Edit</button>
                        <button 
                            class="bg-red-600 text-white px-2 py-1 rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCustomerModal{{ $customer->id }}">
                            Delete
                        </button>

                    </td>
                </tr>

                @include('customers.modals.delete', ['customer' => $customer])
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>

    {{-- Add Modal --}}

    @include('customers.modals.add_edit')

    {{-- JS --}}
    @vite([ 'resources/views/customers/js/customer-form.js'])


</x-layout>



