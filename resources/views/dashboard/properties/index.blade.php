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
        <h1 class="text-4xl font-bold text-green-600 text-center">Properties</h1>

        <div class="mt-20">
            <h2 class="text-2xl font-semibold mb-4 text-center text-beige-600">Create Property</h2>
            <form action="{{ route('dashboard.properties.store') }}" method="POST" class="flex flex-col items-center">
                @csrf
                <label for="title" class="mt-6 block text-sm font-medium text-beige-600">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-600 bg-beige-200 text-green-700 text-center" required>

                <label for="description" class="mt-6 block text-sm font-medium text-beige-600">Description</label>
                <textarea name="description" id="description" class="description-properties mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-600 bg-beige-200 text-green-700 text-center" required></textarea>

                <label for="price" class="mt-6 block text-sm font-medium text-beige-600">Price</label>
                <input type="text" name="price" id="price" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-600 bg-beige-200 text-green-700 text-center" required pattern="^\d{1,3}(\.\d{3})*$" placeholder="1.000">
                <button type="submit" class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Create Property</button>
            </form>
        </div>

        <div class="mt-20">
            <h2 class="text-2xl font-semibold mb-4 text-center text-beige-600">Existing Properties</h2>
            <table class="min-w-full bg-beige-200 border border-green-600 rounded-lg shadow-sm overflow-hidden">
                <thead class="bg-green-500 text-beige-100">
                <tr>
                    <th class="w-1/6 py-2">Title</th>
                    <th class="w-1/3 py-2">Description</th>
                    <th class="w-1/3 py-2">Price</th>
                    <th class="w-1/3 py-2 px-4">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($properties as $property)
                    <tr class="text-center bg-beige-200 border-t border-gray-200">
                        <td class="py-2 text-beige-600">{{ $property->title }}</td>
                        <td class="py-2 text-beige-600">{{ $property->description }}</td>
                        <td class="py-2 text-beige-600">€{{ $property->price }}</td>
                        <td class="py-2">
                            <a href="{{ route('dashboard.properties.show', $property->id) }}" class="text-green-600">View</a>
                            <span class="text-beige-600 mx-2">|</span>
                            <a href="{{ route('dashboard.properties.edit', $property->id) }}" class="text-green-600">Edit</a>
                            <span class="text-beige-600 mx-2">|</span>
                            <form action="{{ route('dashboard.properties.destroy', $property->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
