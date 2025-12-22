document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('jobForm');

    // Clear errors when user edits fields
    [
        '#customer_id',
        'input[name="title"]',
        'select[name="trade_ids[]"]'
    ].forEach(selector => {
        const el = document.querySelector(selector);
        if (!el) return;

        el.addEventListener('input', () => {
            el.parentElement
              .querySelectorAll('.error-text')
              .forEach(err => err.remove());
        });
    });

    form.addEventListener('submit', function (e) {
        let valid = true;

        document.querySelectorAll('.error-text').forEach(e => e.remove());

        // Title
        const title = form.querySelector('input[name="title"]');
        if (!title.value.trim()) {
            showError(title, 'Job title is required.');
            valid = false;
        }

        // Customer
        const customer = form.querySelector('#customer_id');
        if (!customer.value) {
            showError(customer, 'Please select a customer.');
            valid = false;
        }

        // Trades
        const trades = form.querySelector('select[name="trade_ids[]"]');
        if (![...trades.options].some(o => o.selected)) {
            showError(trades, 'Please select at least one trade.');
            valid = false;
        }

        // Photos (ONLY if user selects files)
        const photos = form.querySelector('input[name="photos[]"]');
        if (photos.files.length > 5) {
            showError(photos, 'Maximum 5 photos allowed.');
            valid = false;
        }

        if (!valid) e.preventDefault();
    });
});

function showError(el, msg) {
    const p = document.createElement('p');
    p.className = 'text-red-600 text-sm error-text';
    p.innerText = msg;
    el.parentElement.appendChild(p);
}

