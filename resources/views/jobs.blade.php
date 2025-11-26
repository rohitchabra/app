<x-layout>
    <x-slot:heading>
        Job
    </x-slot:heading>
    
    <div class="space-y-4">
        @foreach($jobs as $job)
            <a href="/jobs/{{$job['id']}}"  class="block px-4 py-2 border-b border-gray-200 rounded-lg">
                <div class="font-bold text-blue-500 text-sm">Employer:
                     {{$job->employer->name}}
                    </div>
                <div><strong>{{$job['title']}}</strong> Pays: {{$job['salary']}} per year <br></div>
            </a> 
        @endforeach
    </div>
</x-layout>