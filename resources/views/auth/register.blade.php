@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-beige-200 p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4 text-green-600">Register</h1>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-beige-600">Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-100 text-green-700 text-center" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-beige-600">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-100 text-green-700 text-center" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-beige-600">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-100 text-green-700 text-center" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-beige-600">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-100 text-green-700 text-center" required>
            </div>
            <div class="mb-4">
                <label for="permission" class="block text-sm font-medium text-beige-600">Permission</label>
                <input type="text" name="permission" id="permission" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 bg-beige-100 text-green-700 text-center" required>
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Register</button>
            </div>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif
        </form>
        <p class="font-bold px-2 text-green-600 text-lg">Already have an account?
            <a href="{{ route('login') }}" class="text-green-600 font-bold hover:underline">Login</a>
        </p>
    </div>
@endsection
