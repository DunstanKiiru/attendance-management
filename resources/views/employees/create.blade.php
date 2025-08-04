<x-app-layout>
    <x-slot name="header">Add Employee</x-slot>

    <form method="POST" action="{{ route('employees.store') }}" class="space-y-4">
        @csrf

        <select name="user_id" class="input" required>
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>

        <input name="department" placeholder="Department" class="input" required>
        <input name="designation" placeholder="Designation" class="input" required>
        <input type="date" name="hire_date" class="input" required>
        <button class="btn btn-primary">Add Employee</button>
    </form>
</x-app-layout>
