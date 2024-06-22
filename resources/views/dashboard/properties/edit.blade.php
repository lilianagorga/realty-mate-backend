@extends('dashboard.layout')

@section('dashboard-content')
    <div class="container mx-auto p-4">
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

                <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Update Property</button>
            </form>
        </div>
    </div>
@endsection
