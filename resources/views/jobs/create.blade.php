<x-layout>
    <x-slot:heading>
        Create Job
    </x-slot:heading>

<form id="jobForm" action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
        <!-- Customer -->
        <div>
            <label class="block font-semibold">Customer</label>
            <select name="customer_id" id="customer_id" class="w-full border p-2 rounded">
                <option value="">-- Select customer --</option>

                @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }} ({{ $c->email ?? 'no email' }})
                    </option>
                @endforeach
            </select>

            <p id="customer_id_error" class="text-red-600 text-sm error-text"></p>
        </div>

        <!-- Job Title -->
        <div>
            <label class="block font-semibold">Job Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border p-2 rounded">
            
            <p id="title_error" class="text-red-600 text-sm error-text"></p>
        </div>

        <!-- Description -->
        <div>
            <label class="block font-semibold">Description</label>
            <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description') }}</textarea>

            <p id="description_error" class="text-red-600 text-sm error-text"></p>
        </div>

        <!-- Photos -->
        <div>
            <label class="block font-semibold">Job Photos</label>
            <input type="file" name="photos[]" multiple class="w-full">

           <p id="photos_error" class="text-red-600 text-sm error-text"></p>

           
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Save Job
        </button>
    </form>

</x-layout>

<script>
document.getElementById('jobForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    // Remove old errors
    document.querySelectorAll('.error-text').forEach(el => el.innerHTML = "");

    fetch("{{ route('jobs.store') }}", {   // use normal web route
        method: "POST",
        headers: {
            "Accept": "application/json"
        },
        body: formData
    })
    .then(async response => {
        if(response.status === 422){
            let data = await response.json();

            for(let field in data.errors){
                let el = document.getElementById(field + "_error");
                if(el){
                    el.innerHTML = data.errors[field][0];
                }
            }
            return;
        }

        if(response.ok){
            let data = await response.json();
            alert(data.message);

            // redirect or clear form
            window.location.reload();  // no full page reload from Laravel
        }
    });
});
</script>
