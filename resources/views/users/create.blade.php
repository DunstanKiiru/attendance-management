<x-app-layout>
    <x-slot name="header">Create User</x-slot>

    <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
        @csrf
        <input name="name" placeholder="Name" class="input" required>
        <input name="email" placeholder="Email" class="input" type="email" required>
        <input name="password" placeholder="Password" class="input" type="password" required>
        <select name="role" class="input">
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary">Create</button>
    </form>
</x-app-layout>
