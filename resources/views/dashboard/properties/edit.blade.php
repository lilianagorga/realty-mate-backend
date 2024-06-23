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
        <h1 class="text-4xl font-bold text-green-600 text-center">Edit Property</h1>

        <div class="mt-20">
            <form action="{{ route('dashboard.properties.update', $property->id) }}" method="POST" class="flex flex-col items-center">
                @csrf
                @method('PUT')
                <label for="title" class="mb-2 block text-sm font-medium text-beige-600">Title</label>
                <input type="text" name="title" id="title" value="{{ $property->title }}" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-600 bg-beige-200 text-green-700 text-center" required>

                <label for="description" class="mb-2 block text-sm font-medium text-beige-600">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-600 bg-beige-200 text-green-700 text-center" required>{{ $property->description }}</textarea>

                <label for="price" class="mb-2 block text-sm font-medium text-beige-600">Price</label>
                <input type="text" name="price" id="price" class="mt-1 block w-1/3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-600 bg-beige-200 text-green-700 text-center" required pattern="^\d{1,3}(\.\d{3})*$" placeholder="1.000">
                <div class="flex justify-center space-x-4">
                    <button type="submit" class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update</button>
                    <a href="{{ route('dashboard.properties.index') }}" class=" mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
