<div class="modal fade" id="addCustomerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="customerForm" action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="modal-body">

            <label>Name</label>
            <input 
                type="text" 
                name="name" 
                class="form-control">
            <p id="name_error" class="text-red-600 text-sm error-text"></p>
            <br>

            <label>Email</label>
            <input 
                type="email" 
                name="email" 
                class="form-control">
            <p id="email_error" class="text-red-600 text-sm error-text"></p>
            <br>

            <label>Phone</label>
            <input 
                type="text" 
                name="phone" 
                class="form-control">
            <p id="phone_error" class="text-red-600 text-sm error-text"></p>
            <br>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>

    </div>
  </div>
</div>
