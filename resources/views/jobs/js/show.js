document.addEventListener('DOMContentLoaded', function () {
    console.log('show-form.js loaded');

    document.querySelectorAll('.view-photo-btn').forEach(button => {
        button.addEventListener('click', function () {
            let jobId = this.dataset.id;

            fetch(`/jobs/${jobId}/photo`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('photoModalBody').innerHTML = html;

                    const modalEl = document.getElementById('photoModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

                    initFileUpload();   // ✅ initialize AFTER HTML loads
                    modal.show();
                })
                .catch(err => console.error(err));
        });
    });
});

let selectedFiles = [];

function initFileUpload() {
    const fileInput = document.getElementById('fileInput');
    const fileCount = document.getElementById('fileCount');
    const preview = document.getElementById('preview');

    if (!fileInput || !preview) return;

    fileInput.addEventListener('change', function () {
        selectedFiles = [...this.files];
        render();
    });

    function render() {
        preview.innerHTML = '';
        fileCount.textContent = `${selectedFiles.length} file(s) selected`;

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-32 object-cover rounded border';

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = '✕';
                btn.className = `
                    absolute top-1 right-1 bg-black/70 text-white
                    rounded-full w-6 h-6 flex items-center justify-center
                `;

                btn.addEventListener('click', () => {
                    selectedFiles.splice(index, 1);
                    syncInput();
                    render();
                });

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                preview.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    }

    function syncInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }
}
