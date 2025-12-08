<div class="mb-3">
    <h5 class="mb-1">{{ $customer->name }}</h5>
    <p class="text-muted mb-3">Jobs associated with this customer.</p>
</div>

@forelse ($customer->jobs as $job)
    <div class="mb-3 rounded border bg-white p-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="mb-1">{{ $job->title }}</h6>
                <div class="text-muted small">{{ $job->status ?? 'No status' }}</div>
            </div>

            <div class="btn-group">
                <a href="{{ route('jobs.show', $job) }}" class="btn btn-sm btn-primary">View</a>
                <a href="{{ route('jobs.edit', $job) }}" class="btn btn-sm btn-warning">Edit</a>
            </div>
        </div>

        @if($job->trades->isNotEmpty())
            <div class="mt-2">
                @foreach ($job->trades as $trade)
                    <span class="badge bg-secondary me-1">{{ $trade->name }}</span>
                @endforeach
            </div>
        @endif

        @if($job->photos->isNotEmpty())
            <div class="mt-2 d-flex gap-2 flex-wrap">
                @foreach ($job->photos->take(4) as $photo)
                    <img src="{{ asset('storage/' . $photo->path) }}" class="img-thumbnail" style="width:64px;height:64px;object-fit:cover;">
                @endforeach

                @if ($job->photos->count() > 4)
                    <span class="align-self-center small text-muted">+{{ $job->photos->count() - 4 }} more</span>
                @endif
            </div>
        @endif
    </div>
@empty
    <div class="text-muted">No jobs found for this customer.</div>
@endforelse
