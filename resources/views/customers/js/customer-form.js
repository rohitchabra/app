document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById('customerForm');

    if (!form) return;

    form.addEventListener('submit', function(e){
        e.preventDefault();

        const formData = new FormData(form);

        document.querySelectorAll('.error-text').forEach(el => el.innerHTML = '');

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                "Accept": "application/json"
            },
            body: formData
        })
        .then(async response => {
            if (response.status === 422) {
                const data = await response.json();
                for (let field in data.errors) {
                    let errorEl = document.getElementById(field + "_error");
                    if (errorEl) errorEl.innerHTML = data.errors[field][0];
                }
                return;
            }

            // Success
            if (response.ok) {
                const json = await response.json();

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addCustomerModal'));
                modal.hide();

                form.reset();

                // Reload page so table is updated
                location.reload();
            }
        })
        .catch(error => console.error("AJAX Error:", error));
    });

});
