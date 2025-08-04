<x-app-layout>
    <x-slot name="header">Apply for Leave</x-slot>

    <form method="POST" action="{{ route('leaves.store') }}" class="space-y-4">
        @csrf

        <select name="type" class="input" required>
            <option value="">Select Leave Type</option>
            <option value="Sick">Sick</option>
            <option value="Annual">Annual</option>
            <option value="Emergency">Emergency</option>
        </select>

        <input type="date" name="start_date" class="input" required />
        <input type="date" name="end_date" class="input" required />

        <textarea name="reason" placeholder="Reason (optional)" class="input"></textarea>

        <button class="btn btn-primary">Submit Leave Request</button>
    </form>
</x-app-layout>
