@extends('dashboard.layout')

@section('dashboard-content')
    <div class="container mx-auto p-4">
        <div x-data="{
                message: '{{ session('success') ?? session('error') }}',
                type: '{{ session('success') ? 'success' : 'error' }}',
                clearForm() {
                    if (this.type === 'success') {
                        document.getElementById('name').value = '';
                        document.getElementById('logo').value = '';
                    }
                }
            }"
             x-show="message"
             x-init="clearForm(); setTimeout(() => message = '', 5000)"
             class="mb-4">
            <div x-show="type === 'success'" class="bg-green-500 text-white p-4 rounded">
                <p x-text="message"></p>
            </div>
            <div x-show="type === 'error'" class="bg-red-500 text-white p-4 rounded">
                <p x-text="message"></p>
            </div>
        </div>
        <h1 class="text-4xl font-bold text-green-600 text-center">Edit Partner</h1>
        <form x-ref="editform" action="{{ route('dashboard.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 max-w-lg mx-auto">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <label for="name" class="block text-sm font-medium text-beige-600">Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" value="{{ $partner->name }}" required>
            </div>
            <div class="form-group mb-4">
                <label for="logo" class="block text-sm font-medium text-beige-600">Logo</label>
                <input type="text" name="logo" id="logo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-200 text-green-700 text-center" value="{{ $partner->logo }}" required>
            </div>
            <div class="flex justify-center space-x-4">
                <button type="submit" class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update</button>
                <a href="{{ route('dashboard.partners.index') }}" class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Back</a>
            </div>
        </form>
    </div>
@endsection
