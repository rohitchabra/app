<x-layout>
    <x-slot:heading>Customers</x-slot:heading>

    <form action="{{ route('customers.index') }}" method="GET">
        <div class="container text-center">
            <div class="row">   
                <div class="col-3">
                    <input type="text" name="title" value="{{ request('title') }}"
                        class="w-full border p-2 rounded" placeholder="Search Name, Email, Phone...">
                </div>
                <div class="col-4">
                    <button class="bg-green-600 text-white px-4 py-2 rounded mt-2">
                        Search
                    </button>
                    <a href="{{ route('customers.index') }}" 
                        class="bg-green-600 text-white px-4 py-2 rounded mt-2 inline-block">
                            Clear
                    </a>
                </div>
                <div class="col-5">
                    @can('create customers')
                        <button type="button" class="btn btn-success mt-2" 
                            onclick="openCustomerModal('add')">Add Customer</button>
                    @endcan
                    <a href="{{ route('customers.export') }}" class="btn btn-success mt-2">
                        Excel
                    </a>
                    
                    <a href="{{ route('customers.export.pdf') }}" class="btn btn-danger mt-2">
                        PDF
                    </a>
                    
                </div>
            </div>
        </div>
    </form>


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
                        @can('edit customers')
                            <button type="button" class="btn btn-primary" 
                            onclick="openCustomerModal('edit', {{ $customer->id }})">Edit</button>
                        @endcan
                        @can('delete customers')
                            <button 
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteCustomerModal{{ $customer->id }}">
                                Delete
                            </button>
                        @endcan
                        @can('edit customers')
                            <button type="button" class="btn btn-primary" onclick="viewJobs({{ $customer->id }})">
                                View Jobs ({{ $customer->jobs_count }})
                            </button>
                        @endcan    
                            {{-- <button type="button" class="btn btn-primary"
                            onclick="openJobsModal({{ $customer->id }})">View Jobs</button> --}}
                         {{-- @endif --}}
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

    {{-- @include('customers.modals.partials.jobs-list') --}}

    {{-- JS --}}
    @vite([ 'resources/views/customers/js/customer-form.js'])

</x-layout>

<script>
    function viewJobs(customerId) {
        window.location.href = `/jobs?customer_id=${customerId}`;
    }
</script>

<script>
    async function openJobsModall(customerId) {
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
    


