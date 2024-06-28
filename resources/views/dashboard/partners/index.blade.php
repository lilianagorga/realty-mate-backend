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
        <h1 class="text-4xl font-bold text-green-600 text-center">Partners</h1>
        <a href="{{ route('dashboard.partners.create') }}" class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block">Add Partner</a>
        <table class="min-w-full bg-beige-200 border border-green-600 rounded-lg shadow-sm overflow-hidden mt-4 mx-auto">
            <thead class="bg-green-500 text-beige-100">
            <tr>
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Logo</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($partners as $partner)
                <tr class="bg-beige-200 border-t border-gray-200 text-center">
                    <td class="py-2 px-4 text-beige-600">{{ $partner->name }}</td>
                    <td class="py-2 px-4 text-beige-600 flex justify-center items-center"><img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="w-24 h-24 object-contain"></td>
                    <td class="py-2 px-4">
                        <a href="{{ route('dashboard.partners.edit', $partner->id) }}" class="text-green-600 hover:text-green-700">Edit</a>
                        <span class="text-beige-600 mx-2">|</span>
                        <form action="{{ route('dashboard.partners.destroy', $partner->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
