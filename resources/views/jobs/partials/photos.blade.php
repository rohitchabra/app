
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
        class="hidden"
        >

    <button id="selectBtn" type="button"
            onclick="document.getElementById('fileInput').click()"
            class="bg-green-600 text-white px-4 py-2 rounded mt-2">
        Select Photos
    </button>

    <p id="fileCount" class="text-sm text-gray-500 mt-2"></p>

    <div id="preview" class="grid grid-cols-4 gap-4 mt-4"></div>

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
            >
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

