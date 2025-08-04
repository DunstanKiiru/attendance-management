<x-app-layout>
    <x-slot name="header">Edit User</x-slot>

    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
        @csrf @method('PUT')
        <input name="name" value="{{ $user->name }}" class="input" required>
        <input name="email" value="{{ $user->email }}" class="input" type="email" required>
        <select name="role" class="input">
            @foreach($roles as $role)
                <option value="{{ $role->name }}" @if($user->hasRole($role->name)) selected @endif>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        <button class="btn btn-success">Update</button>
    </form>
</x-app-layout>
