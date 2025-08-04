<x-app-layout>
    <x-slot name="header">Employees</x-slot>

    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-4">+ Add Employee</a>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>User Name</th><th>Department</th><th>Designation</th><th>Hire Date</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr class="border-t">
                <td>{{ $employee->user->name }}</td>
                <td>{{ $employee->department }}</td>
                <td>{{ $employee->designation }}</td>
                <td>{{ $employee->hire_date->format('Y-m-d') }}</td>
                <td>{{ $employee->status }}</td>
                <td>
                    <a href="{{ route('employees.edit', $employee) }}" class="text-blue-500">Edit</a>
                    <form method="POST" action="{{ route('employees.destroy', $employee) }}" class="inline">@csrf @method('DELETE')
                        <button class="text-red-500" onclick="return confirm('Delete employee?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
