@extends('dashboard.layout')

@section('dashboard-content')
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <p>Welcome to the dashboard.</p>

    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Roles Management</h2>
        <div class="mb-4">
            <form action="{{ route('dashboard.create-role') }}" method="POST">
                @csrf
                <label for="role-name" class="block text-sm font-medium text-gray-700">Create Role</label>
                <input type="text" name="name" id="role-name" class="mt-1 block w-full" required>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Create Role</button>
            </form>
        </div>
        <div class="mb-4">
            <form action="{{ route('dashboard.update-role') }}" method="POST">
                @csrf
                @method('PUT')
                <label for="update-role-name" class="block text-sm font-medium text-gray-700">Update Role</label>
                <input type="text" name="name" id="update-role-name" class="mt-1 block w-full" required>
                <label for="permissions" class="block text-sm font-medium text-gray-700">Permissions</label>
                <input type="text" name="permissions[]" id="permissions" class="mt-1 block w-full" required>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Update Role</button>
            </form>
        </div>
        <div class="mb-4">
            <form action="{{ route('dashboard.delete-role') }}" method="POST">
                @csrf
                @method('DELETE')
                <label for="delete-role-name" class="block text-sm font-medium text-gray-700">Delete Role</label>
                <input type="text" name="name" id="delete-role-name" class="mt-1 block w-full" required>
                <button type="submit" class="mt-2 bg-red-500 text-white px-4 py-2 rounded">Delete Role</button>
            </form>
        </div>
        <div class="mb-4">
            <form action="{{ route('dashboard.add-role') }}" method="POST">
                @csrf
                <label for="user-id" class="block text-sm font-medium text-gray-700">Assign Role to User</label>
                <input type="number" name="user_id" id="user-id" class="mt-1 block w-full" required>
                <label for="assign-role-name" class="block text-sm font-medium text-gray-700">Role Name</label>
                <input type="text" name="name" id="assign-role-name" class="mt-1 block w-full" required>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Assign Role</button>
            </form>
        </div>
        <div class="mb-4">
            <form action="{{ route('dashboard.revoke-role') }}" method="POST">
                @csrf
                <label for="revoke-user-id" class="block text-sm font-medium text-gray-700">Revoke Role from User</label>
                <input type="number" name="user_id" id="revoke-user-id" class="mt-1 block w-full" required>
                <label for="revoke-role-name" class="block text-sm font-medium text-gray-700">Role Name</label>
                <input type="text" name="name" id="revoke-role-name" class="mt-1 block w-full" required>
                <button type="submit" class="mt-2 bg-red-500 text-white px-4 py-2 rounded">Revoke Role</button>
            </form>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Permissions Management</h2>
        <div class="mb-4">
            <form action="{{ route('dashboard.create-permission') }}" method="POST">
                @csrf
                <label for="permission-name" class="block text-sm font-medium text-gray-700">Create Permission</label>
                <input type="text" name="name" id="permission-name" class="mt-1 block w-full" required>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Create Permission</button>
            </form>
        </div>
        <div class="mb-4">
            <form action="{{ route('dashboard.delete-permission') }}" method="POST">
                @csrf
                @method('DELETE')
                <label for="delete-permission-name" class="block text-sm font-medium text-gray-700">Delete Permission</label>
                <input type="text" name="name" id="delete-permission-name" class="mt-1 block w-full" required>
                <button type="submit" class="mt-2 bg-red-500 text-white px-4 py-2 rounded">Delete Permission</button>
            </form>
        </div>
        <div class="mb-4">
            <form action="{{ route('dashboard.add-permission') }}" method="POST">
                @csrf
                <label for="permission-user-id" class="block text-sm font-medium text-gray-700">Assign Permission to User</label>
                <input type="number" name="user_id" id="permission-user-id" class="mt-1 block w-full" required>
                <label for="assign-permission-name" class="block text-sm font-medium text-gray-700">Permission Name</label>
                <input type="text" name="name" id="assign-permission-name" class="mt-1 block w-full" required>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Assign Permission</button>
            </form>
        </div>
        <div class="mb-4">
            <form action="{{ route('dashboard.revoke-permission') }}" method="POST">
                @csrf
                <label for="revoke-permission-user-id" class="block text-sm font-medium text-gray-700">Revoke Permission from User</label>
                <input type="number" name="user_id" id="revoke-permission-user-id" class="mt-1 block w-full" required>
                <label for="revoke-permission-name" class="block text-sm font-medium text-gray-700">Permission Name</label>
                <input type="text" name="name" id="revoke-permission-name" class="mt-1 block w-full" required>
                <button type="submit" class="mt-2 bg-red-500 text-white px-4 py-2 rounded">Revoke Permission</button>
            </form>
        </div>
    </div>
@endsection
