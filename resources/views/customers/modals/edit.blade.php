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
            <input 
                type="text" 
                name="name" 
                class="form-control"
                value="{{ $customer->name }}">

            <label class="mt-3">Email</label>
            <input 
                type="email" 
                name="email" 
                class="form-control"
                value="{{ $customer->email }}">

            <label class="mt-3">Phone</label>
            <input 
                type="text" 
                name="phone" 
                class="form-control"
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
