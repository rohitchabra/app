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

                    initFileUpload?.();
                    modal.show();
                })
                .catch(err => console.error(err));

                });
            });
});

function initFileUpload() {
    const fileInput = document.getElementById('fileInput');
    const fileCount = document.getElementById('fileCount');
    const preview = document.getElementById('preview');

    if (!fileInput) return;

    fileInput.onchange = function () {
        preview.innerHTML = '';
        const files = this.files;

        if (!files.length) {
            fileCount.textContent = '';
            return;
        }

        fileCount.textContent = `${files.length} file(s) selected`;

        [...files].forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '120px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    };
}
