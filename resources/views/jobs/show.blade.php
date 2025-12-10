<div>
    <h3 class="text-lg font-bold mb-3">Job #{{ $job->id }} Photos</h3>

    @if($job->photos && $job->photos->count())
        <div class="grid grid-cols-3 gap-4">
            @foreach ($job->photos as $photo)
                <img src="{{ asset('storage/' . $photo->path) }}" class="w-full rounded shadow">
            @endforeach
        </div>
    @else
        <p>No photos available.</p>
    @endif
</div>

  
    
    
