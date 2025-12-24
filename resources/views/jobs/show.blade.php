<form id="dropzone"
      class="hidden border-2 border-dashed border-gray-400 rounded-lg p-6 text-center mt-6"
      action="{{ route('jobs.photos.upload', $job) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    <p class="text-gray-500 mb-2">
        Drag & drop photos here or click to select
    </p>

    <input type="file"
           id="fileInput"
           name="photos[]"
           multiple
           accept="image/*"
           class="hidden">

    <button type="button"
            onclick="fileInput.click()"
            class="bg-green-600 text-white px-4 py-2 rounded mt-2">
        Select Photos
    </button>

    <p id="fileCount" class="text-sm text-gray-500 mt-2"></p>

    <div id="preview" class="grid grid-cols-3 gap-4 mt-4"></div>

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
        Upload
    </button>
</form>
<form method="POST" action="{{ route('jobs.photos.bulk-delete') }}">
    @csrf
    @method('DELETE')
    <div class="flex gap-3 mt-4">
        <button
            type="button"
            class="bg-green-600 text-white px-4 py-2 rounded"
            onclick="document.getElementById('dropzone').classList.toggle('hidden')">
            Upload Photos
        </button>

        <button
            type="submit"
            class="bg-red-600 text-white px-4 py-2 rounded"
            onclick="return confirm('Delete selected photos?')">
            Delete Selected
        </button>
    </div>

    <div class="grid grid-cols-4 gap-4 mt-6">
        @foreach($job->photos as $photo)
            <label class="relative cursor-pointer block">
                <input
                    type="checkbox"
                    name="photo_ids[]"
                    value="{{ $photo->id }}"
                    class="peer hidden"
                >

                <img
                    src="{{ asset('storage/'.$photo->path) }}"
                    class="h-32 w-full object-cover rounded
                           border-2 border-transparent
                           peer-checked:border-red-600"
                >
            </label>
        @endforeach
    </div>
</form>



<script>
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');
const preview = document.getElementById('preview');
const fileCount = document.getElementById('fileCount');

function toggleUpload() {
    dropzone.classList.toggle('hidden');
}

// drag events
dropzone.addEventListener('dragover', e => {
    e.preventDefault();
    dropzone.classList.add('bg-gray-100');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('bg-gray-100');
});

dropzone.addEventListener('drop', e => {
    e.preventDefault();
    dropzone.classList.remove('bg-gray-100');
    fileInput.files = e.dataTransfer.files;
    updatePreview(fileInput.files);
});

fileInput.addEventListener('change', () => {
    updatePreview(fileInput.files);
});

function updatePreview(files) {
    preview.innerHTML = '';
    fileCount.textContent = '';

    if (!files.length) return;

    fileCount.textContent = `${files.length} file(s) selected`;

    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'h-32 w-full object-cover rounded shadow';
        preview.appendChild(img);
    });
}
</script>
