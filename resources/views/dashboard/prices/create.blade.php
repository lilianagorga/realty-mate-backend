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
        <h1 class="text-4xl font-bold text-green-600 text-center">Create Price</h1>
        <form action="{{ route('dashboard.prices.store') }}" method="POST" class="mt-4 max-w-lg mx-auto">
            @csrf
            <div class="form-group mb-4">
                <label for="plan" class="block text-sm font-medium text-beige-600">Plan</label>
                <input type="text" name="plan" id="plan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
            </div>
            <div class="form-group mb-4">
                <label for="price" class="block text-sm font-medium text-beige-600">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
            </div>
            <div class="form-group mb-4">
                <label for="ptext" class="block text-sm font-medium text-beige-600">Ptext</label>
                <input type="text" name="ptext" id="ptext" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" required>
            </div>
            <div class="form-group mb-4">
                <label for="best" class="block text-sm font-medium text-beige-600">Best (optional)</label>
                <input type="text" name="best" id="best" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center">
            </div>
            <div class="flex justify-center space-x-4">
                <button type="submit" class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create</button>
                <a href="{{ route('dashboard.prices.index') }}" class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Back</a>
            </div>
        </form>
    </div>
@endsection
