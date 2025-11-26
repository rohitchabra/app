<x-layout>
    <x-slot:heading>
        {{ $job->title }}
    </x-slot:heading>

    <p>This job pays <strong>{{ $job->salary ?? '--' }}</strong> per year.</p>

    <a href="/jobs" class="text-blue-400 hover:underline mt-4 inline-block">← Back to all jobs</a>
</x-layout>