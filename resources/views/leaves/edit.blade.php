<x-app-layout>
    <x-slot name="header">Update Leave Status</x-slot>

    <form method="POST" action="{{ route('leaves.update', $leave) }}" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label>Employee:</label>
            <span>{{ $leave->employee->user->name }}</span>
        </div>

        <div>
            <label>Leave Type:</label>
            <span>{{ $leave->type }}</span>
        </div>

        <div>
            <label>Start Date:</label>
            <span>{{ $leave->start_date->format('Y-m-d') }}</span>
        </div>

        <div>
            <label>End Date:</label>
            <span>{{ $leave->end_date->format('Y-m-d') }}</span>
        </div>

        <div>
            <label>Reason:</label>
            <p>{{ $leave->reason ?? '-' }}</p>
        </div>

        <select name="status" class="input" required>
            <option value="Pending" @if($leave->status === 'Pending') selected @endif>Pending</option>
            <option value="Approved" @if($leave->status === 'Approved') selected @endif>Approved</option>
            <option value="Rejected" @if($leave->status === 'Rejected') selected @endif>Rejected</option>
        </select>

        <button class="btn btn-success">Update Status</button>
    </form>
</x-app-layout>
