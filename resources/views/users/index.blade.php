<x-app-layout>
    <x-slot name="header">Users</x-slot>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-4">+ Add User</a>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-t">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles->pluck('name')->first() }}</td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="text-blue-500">Edit</a>
                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline">@csrf @method('DELETE')
                        <button class="text-red-500" onclick="return confirm('Delete user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
