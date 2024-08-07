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
        <h1 class="text-4xl font-bold text-green-600 text-center">Teams</h1>
        @if (Auth::user()->canManageTeam())
            <a href="{{ route('dashboard.teams.create') }}" class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block">Add Team</a>
        @else
            <a href="#" class="mt-6 bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed inline-block" title="You don't have permission to create teams">Add Team</a>
        @endif
        <table class="min-w-full bg-beige-200 border border-green-600 rounded-lg shadow-sm overflow-hidden mt-4 mx-auto">
            <thead class="bg-green-500 text-beige-100">
            <tr>
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Address</th>
                <th class="py-2 px-4">List</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($teams as $team)
                <tr class="bg-beige-200 border-t border-gray-200 text-center">
                    <td class="py-2 px-4 text-beige-600">{{ $team->name }}</td>
                    <td class="py-2 px-4 text-beige-600">{{ $team->address }}</td>
                    <td class="py-2 px-4 text-beige-600">{{ $team->list }}</td>
                    <td class="py-2 px-4">
                        @if (Auth::user()->canManageTeam())
                            <a href="{{ route('dashboard.teams.edit', $team->id) }}" class="text-green-600 hover:text-green-700">Edit</a>
                            <span class="text-beige-600 mx-2 hidden lg:inline">|</span>
                            <form action="{{ route('dashboard.teams.destroy', $team->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">Delete</button>
                            </form>
                        @else
                            <a href="#" class="text-gray-400 cursor-not-allowed" title="You don't have permission to edit teams">Edit</a>
                            <span class="text-beige-600 mx-2 hidden lg:inline">|</span>
                            <form class="inline">
                                <button type="button" class="text-gray-400 cursor-not-allowed" title="You don't have permission to delete teams">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
