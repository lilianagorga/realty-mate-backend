@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="max-w-md mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-4">Register</h1>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Register</button>
            </div>
        </form>
    </div>
@endsection
