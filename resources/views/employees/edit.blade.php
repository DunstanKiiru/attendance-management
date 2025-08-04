<x-app-layout>
    <x-slot name="header">Edit Employee</x-slot>

    <form method="POST" action="{{ route('employees.update', $employee) }}" class="space-y-4">
        @csrf @method('PUT')

        <input value="{{ $employee->user->name }}" disabled class="input" />

        <input name="department" value="{{ $employee->department }}" placeholder="Department" class="input" required>
        <input name="designation" value="{{ $employee->designation }}" placeholder="Designation" class="input" required>
        <input type="date" name="hire_date" value="{{ $employee->hire_date->format('Y-m-d') }}" class="input" required>

        <select name="status" class="input" required>
            <option value="Active" @if($employee->status == 'Active') selected @endif>Active</option>
            <option value="Suspended" @if($employee->status == 'Suspended') selected @endif>Suspended</option>
            <option value="Terminated" @if($employee->status == 'Terminated') selected @endif>Terminated</option>
        </select>

        <button class="btn btn-success">Update Employee</button>
    </form>
</x-app-layout>
