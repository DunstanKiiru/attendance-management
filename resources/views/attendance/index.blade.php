<x-app-layout>
    <x-slot name="header">My Attendance</x-slot>

    @if(session('success'))
        <div class="p-3 bg-green-200 text-green-800 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="mb-6 flex space-x-4">
        <form method="POST" action="{{ route('attendance.clockin') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Clock In</button>
        </form>

        <form method="POST" action="{{ route('attendance.clockout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">Clock Out</button>
        </form>
    </div>

    <div class="mb-4">
        <a href="{{ route('attendance.export.csv') }}" class="btn btn-info mr-2">Export CSV</a>
        <a href="{{ route('attendance.export.pdf') }}" class="btn btn-info">Export PDF</a>
    </div>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Date</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $att)
                <tr class="border-t">
                    <td>{{ $att->date->format('Y-m-d') }}</td>
                    <td>{{ $att->clock_in ? $att->clock_in->format('H:i:s') : '-' }}</td>
                    <td>{{ $att->clock_out ? $att->clock_out->format('H:i:s') : '-' }}</td>
                    <td>{{ $att->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-4">No attendance records yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-app-layout>
