<h2>Jobs List</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Customers</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            {{-- <th>Trade</th>
            <th>Photos</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($jobs as $job)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $job->customer?->name ?? 'N/A' }}</td>
                <td>{{ $job->title }}</td>
                <td>{{ $job->description }}</td>
                <td>{{ $job->status }}</td>
                {{-- <td>{{ $job->trade?->name ?? 'N/A' }}</td>
                <td>{{ $job->photos->count() }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
