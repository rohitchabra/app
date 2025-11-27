<x-layout>
    <x-slot:heading>Customers</x-slot:heading>

    <!-- Add Customer Button -->
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


                <!-- EDIT MODAL -->
                <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title">Edit Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">

                            <label>Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ $customer->name }}" required>

                            <label class="mt-3">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ $customer->email }}">

                            <label class="mt-3">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ $customer->phone }}">

                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>


                <!-- DELETE MODAL -->
                <div class="modal fade" id="deleteCustomerModal{{ $customer->id }}" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title text-red-600">Delete Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <div class="modal-body">
                        Are you sure you want to delete <strong>{{ $customer->name }}</strong>?
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>

                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>
</x-layout>


<!-- ADD CUSTOMER MODAL -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div class="modal-body">

            <label>Name</label>
            <input type="text" name="name" class="form-control" required>

            <label class="mt-3">Email</label>
            <input type="email" name="email" class="form-control">

            <label class="mt-3">Phone</label>
            <input type="text" name="phone" class="form-control">

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>

    </div>
  </div>
</div>

