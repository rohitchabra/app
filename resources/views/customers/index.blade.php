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
                        <button type="button" class="btn btn-primary" 
                        onclick="openCustomerModal('edit', {{ $customer->id }})">Edit</button>
                        <button 
                            class="bg-red-600 text-white px-2 py-1 rounded"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCustomerModal{{ $customer->id }}">
                            Delete
                        </button>
                        <button type="button" class="btn btn-primary"
                         onclick="openJobsModal({{ $customer->id }})">View Jobs</button>
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

    @include('customers.modals.jobs')

    {{-- @include('customers.modals.partials.jobs-list') --}}

    {{-- JS --}}
    @vite([ 'resources/views/customers/js/customer-form.js'])

</x-layout>

<script>
    async function openJobsModal(customerId) {
    console.log('Opening jobs modal for customer:', customerId);

    const modalBody = document.getElementById('jobsModalBody');
    modalBody.innerHTML = '<div class="text-center text-muted">Loading...</div>';

    try {
        const response = await fetch(`/customers/${customerId}/jobs`);
        const html = await response.text();

        modalBody.innerHTML = html;

        const modal = new bootstrap.Modal(document.getElementById('jobsModal'));
        modal.show();

    } catch (error) {
        modalBody.innerHTML = '<div class="text-danger">Failed to load jobs.</div>';
        console.error(error);
    }
}

</script>
    async function openJobsModal2(customerId) {
        const modalBody = document.getElementById('jobsModalBody');
    
        modalBody.innerHTML = '<div class="text-center text-muted">Loading...</div>';
    
        const jobsModalEl = document.getElementById('jobsModal');
        const jobsModal = new bootstrap.Modal(jobsModalEl); // FIXED
        jobsModal.show();
        console.log('Opening jobs modal for customer:', customerId);

        $.ajax({
            url: '/customers/' + customerId + '/jobs',
            type: 'GET',
            success: function(response) {
                //$('#jobsModalBody').html(response);
                modalBody.innerHTML = response;
            }
        });
        $('#jobsModal').modal('show');
        
    }
    </script>
    


