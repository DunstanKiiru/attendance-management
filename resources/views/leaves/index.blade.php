<x-app-layout>
    <x-slot name="header">Leave Requests</x-slot>

    @if(session('success'))
        <div class="p-3 bg-green-200 text-green-800 rounded mb-4">{{ session('success') }}</div>
    @endif

    <a href="{{ route('leaves.create') }}" class="btn btn-primary mb-4">+ Apply for Leave</a>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaves as $leave)
                <tr class="border-t">
                    <td>{{ $leave->employee->user->name }}</td>
                    <td>{{ $leave->type }}</td>
                    <td>{{ $leave->start_date->format('Y-m-d') }}</td>
                    <td>{{ $leave->end_date->format('Y-m-d') }}</td>
                    <td>{{ $leave->status }}</td>
                    <td>
                        @if(auth()->user()->hasAnyRole(['Admin','HR']))
                            <a href="{{ route('leaves.edit', $leave) }}" class="text-blue-500">Edit</a>
                        @endif
                        <form method="POST" action="{{ route('leaves.destroy', $leave) }}" class="inline">@csrf @method('DELETE')
                            <button class="text-red-500" onclick="return confirm('Delete leave request?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $leaves->links() }}
</x-app-layout>
