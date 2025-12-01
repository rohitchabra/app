<!-- Button examples (put where appropriate) -->

<!-- Example edit button within each row (assuming you have $customer in the row):
     You can either set data-json with JSON or just call openCustomerModal('edit', id) which will fetch customer data.
-->
{{-- <button type="button" class="btn btn-primary" onclick="openCustomerModal('edit', {{ $customer->id }})">Edit</button> --}}

<!-- Single Modal -->
<div class="modal fade" id="customerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customerModalTitle">Add New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="customerForm" action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <!-- We'll set this method input dynamically (for update we'll set value to PUT) -->
        <input type="hidden" name="_method" id="form_method_input" value="">

        <div class="modal-body">
            <label>Name</label>
            <input 
                type="text" 
                name="name" 
                id="name"
                class="form-control">
            <p id="name_error" class="text-red-600 text-sm error-text"></p>
            <br>

            <label>Email</label>
            <input 
                type="email" 
                name="email" 
                id="email"
                class="form-control">
            <p id="email_error" class="text-red-600 text-sm error-text"></p>
            <br>

            <label>Phone</label>
            <input 
                type="text" 
                name="phone" 
                id="phone"
                class="form-control">
            <p id="phone_error" class="text-red-600 text-sm error-text"></p>
            <br>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="customerFormSubmitButton" class="btn btn-primary">Create</button>
        </div>
      </form>

    </div>
  </div>
</div>