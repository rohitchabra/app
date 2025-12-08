// customer-form.js
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('customerForm');
    
    if (!form) return;

    const modalEl = document.getElementById('customerModal');
    const bsModal = new bootstrap.Modal(modalEl);
    const titleEl = document.getElementById('customerModalTitle');
    const submitBtn = document.getElementById('customerFormSubmitButton');
    const methodInput = document.getElementById('form_method_input');
    let customerStoreUrl = '{{ route("customers.store") }}';

    // Auto-remove error on typing
    ['name', 'email', 'phone'].forEach(field => {
        const input = document.getElementById(field);
        const error = document.getElementById(field + '_error');

        if (input) {
            input.addEventListener('input', function () {
                if (error) error.innerHTML = '';
            });
        }
    });

    const phoneInput = document.getElementById('phone');

    phoneInput.addEventListener('input', function () {
        // Remove all non-digits
        this.value = this.value.replace(/\D/g, '');

        // Limit to 10 digits
        if (this.value.length > 10) {
            this.value = this.value.substring(0, 10);
        }

        phoneInput.addEventListener('blur', function () {
            if (this.value.length !== 10) {
                document.getElementById('phone_error').innerHTML = "Phone must be exactly 10 digits.";
                return;
            } else {
                document.getElementById('phone_error').innerHTML = "";
                return;
            }
        });


        // Remove error if valid length (optional)
        if (this.value.length === 10) {
            document.getElementById('phone_error').innerHTML = "";
        }
    });


    // Utility to clear errors
    function clearErrors() {
        document.querySelectorAll('.error-text').forEach(el => el.innerHTML = '');
    }

    // Open modal helper: mode = 'add' or 'edit', id optional
    window.openCustomerModal = async function (mode = 'add', id = null) {
        clearErrors();
        form.reset();
        methodInput.value = '';
        // default action to store
        form.action = '{{ route("customers.store") }}';

        if (mode === 'add') {
            titleEl.innerText = 'Add New Customer';
            submitBtn.innerText = 'Create';
            // ensure method is POST
            methodInput.value = '';
            form.action = '/customers';

            document.getElementById('email').style.backgroundColor = "";
            document.getElementById('phone').style.backgroundColor = "";
        } else if (mode === 'edit') {
           
            titleEl.innerText = 'Edit Customer';
            submitBtn.innerText = 'Update';
            // set form action to update route
            form.action = `/customers/${id}`;
            methodInput.value = 'PUT';

            document.getElementById('email').setAttribute('readonly', true);
            document.getElementById('email').style.backgroundColor = "#f1d5d5ff";
            //document.getElementById('phone').setAttribute('readonly', true);
            //document.getElementById('phone').style.backgroundColor = "#f1d5d5ff";
            // Try to fetch existing customer data via AJAX
            try {
                const res = await fetch(`/customers/${id}` + '/edit', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (res.ok) {
                    const data = await res.json();
                    document.getElementById('name').value = data.name ?? '';
                    document.getElementById('email').value = data.email ?? '';
                    document.getElementById('phone').value = data.phone ?? '';
                } else {
                    // If fetch failed, still open modal but without prefill
                    console.error('Could not fetch customer data.', res.status);
                }
            } catch (err) {
                console.error('Error fetching customer:', err);
            }
        }

        bsModal.show();
    };

    // Submit handler
    form.addEventListener('submit', function(e){
        e.preventDefault();

        const formData = new FormData(form);
        console.log('Submitting form to:', form.action, customerStoreUrl);
        clearErrors();

            fetch(form.action, {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    "Accept": "application/json"
                },
                body: formData
            })
        .then(async response => {
            //console.log('Response status:', response);
            if (response.status === 422) {
                const data = await response.json();
                if (data.errors) {
                    for (let field in data.errors) {
                        let errorEl = document.getElementById(field + "_error");
                        if (errorEl) errorEl.innerHTML = data.errors[field][0];
                    }
                }
                return;
            }

            if (!response.ok) {
                // other server error
                const text = await response.text();
                console.error('Server error:', response.status, text);
                return;
            }

            const json = await response.json();

            // Close modal
            bsModal.hide();

            form.reset();

            // Option: update the table row in-place using json.customer
            // Simpler: reload page so table updates
            location.reload();
        })
        .catch(error => {
            console.error("AJAX Error:", error);
        });
    });
});
