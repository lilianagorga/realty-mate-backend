@extends('dashboard.layout')

@section('dashboard-content')
    <h1 class="text-2xl font-bold mb-4">Create Role</h1>
    <form action="{{ route('dashboard.create-role') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Role</button>
        </div>
    </form>
@endsection
