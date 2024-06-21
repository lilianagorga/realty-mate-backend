@extends('dashboard.layout')

@section('dashboard-content')
    <div class="container mx-auto p-4">
        <div x-data="{ message: '{{ session('success') ?? session('error') }}', type: '{{ session('success') ? 'success' : 'error' }}' }" x-show="message" x-init="setTimeout(() => message = '', 5000)" class="mb-4">
            <div x-show="type === 'success'" class="bg-green-500 text-white p-4 rounded">
                <p x-text="message"></p>
            </div>
            <div x-show="type === 'error'" class="bg-red-500 text-white p-4 rounded">
                <p x-text="message"></p>
            </div>
        </div>
        <h1 class="text-4xl font-bold text-green-600 text-center">Welcome to the dashboard</h1>

        <div class="mt-20">
            <h2 class="text-2xl font-semibold mb-4 text-center text-beige-600">Roles Management</h2>
            <div class="mb-12">
                <form action="{{ route('dashboard.create-role') }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    <label for="role-name" class="mb-2 block text-sm font-medium text-beige-600">Create Role</label>
                    <input type="text" name="name" id="role-name" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
                    <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Create Role</button>
                </form>
            </div>
            <div class="mb-12">
                <form action="{{ route('dashboard.update-role') }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    @method('PUT')
                    <label for="update-role-name" class="block text-sm font-medium text-beige-600 mb-2">Update Role</label>
                    <input type="text" name="name" id="update-role-name" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 mb-2 text-green-700 text-center" required>
                    <label for="permissions" class="block text-sm font-medium text-beige-600 mb-2">Permissions</label>
                    <input type="text" name="permissions[]" id="permissions" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
                    <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Update Role</button>
                </form>
            </div>
            <div class="mb-12">
                <form action="{{ route('dashboard.delete-role') }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    @method('DELETE')
                    <label for="delete-role-name" class="block text-sm font-medium text-beige-600 mb-2">Delete Role</label>
                    <input type="text" name="name" id="delete-role-name" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
                    <button type="submit" class="mt-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mb-4">Delete Role</button>
                </form>
            </div>
            <div class="mb-12">
                <form action="{{ route('dashboard.add-role') }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    <label for="user-id" class="block text-sm font-medium text-beige-600 mb-2">Assign Role to User</label>
                    <input type="number" name="user_id" id="user-id" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 mb-2 text-green-700 text-center" required>
                    <label for="assign-role-name" class="block text-sm font-medium text-beige-600 mb-2">Role Name</label>
                    <input type="text" name="name" id="assign-role-name" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
                    <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Assign Role</button>
                </form>
            </div>
            <div class="mb-12">
                <form action="{{ route('dashboard.revoke-role') }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    <label for="revoke-user-id" class="block text-sm font-medium text-beige-600 mb-2">Revoke Role from User</label>
                    <input type="number" name="user_id" id="revoke-user-id" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 mb-2 text-green-700 text-center" required>
                    <label for="revoke-role-name" class="block text-sm font-medium text-beige-600 mb-2">Role Name</label>
                    <input type="text" name="name" id="revoke-role-name" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
                    <button type="submit" class="mt-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mb-4">Revoke Role</button>
                </form>
            </div>
        </div>

        <div class="mt-20">
            <h2 class="text-2xl font-semibold mb-4 text-center text-beige-600">Permissions Management</h2>
            <div class="mb-12">
                <form action="{{ route('dashboard.create-permission') }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    <label for="permission-name" class="block text-sm font-medium text-beige-600 mb-2">Create Permission</label>
                    <input type="text" name="name" id="permission-name" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
                    <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Create Permission</button>
                </form>
            </div>
            <div class="mb-12">
                <form action="{{ route('dashboard.delete-permission') }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    @method('DELETE')
                    <label for="delete-permission-name" class="block text-sm font-medium text-beige-600 mb-2">Delete Permission</label>
                    <input type="text" name="name" id="delete-permission-name" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
                    <button type="submit" class="mt-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mb-4">Delete Permission</button>
                </form>
            </div>
            <div class="mb-12">
                <form action="{{ route('dashboard.add-permission') }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    <label for="permission-user-id" class="block text-sm font-medium text-beige-600 mb-2">Assign Permission to User</label>
                    <input type="number" name="user_id" id="permission-user-id" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 mb-2 text-green-700 text-center" required>
                    <label for="assign-permission-name" class="block text-sm font-medium text-beige-600 mb-2">Permission Name</label>
                    <input type="text" name="name" id="assign-permission-name" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
                    <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Assign Permission</button>
                </form>
            </div>
            <div class="mb-12">
                <form action="{{ route('dashboard.revoke-permission') }}" method="POST" class="flex flex-col items-center">
                    @csrf
                    <label for="revoke-permission-user-id" class="block text-sm font-medium text-beige-600 mb-2">Revoke Permission from User</label>
                    <input type="number" name="user_id" id="revoke-permission-user-id" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 mb-2 text-green-700 text-center" required>
                    <label for="revoke-permission-name" class="block text-sm font-medium text-beige-600 mb-2">Permission Name</label>
                    <input type="text" name="name" id="revoke-permission-name" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
                    <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Revoke Permission</button>
                </form>
            </div>
        </div>
    </div>
@endsection
