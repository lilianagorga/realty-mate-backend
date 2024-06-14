{{--@extends('layouts.app')--}}

{{--@section('title', 'Login')--}}

{{--@section('content')--}}
{{--    <div class="max-w-md mx-auto mt-10">--}}
{{--        <h1 class="text-3xl font-bold mb-4">Login</h1>--}}
{{--        <form action="{{ route('login') }}" method="POST">--}}
{{--            @csrf--}}
{{--            <div class="mb-4">--}}
{{--                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>--}}
{{--                <input type="email" name="email" id="email" class="mt-1 block w-full" required>--}}
{{--            </div>--}}
{{--            <div class="mb-4">--}}
{{--                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>--}}
{{--                <input type="password" name="password" id="password" class="mt-1 block w-full" required>--}}
{{--            </div>--}}
{{--            <div class="mb-4">--}}
{{--                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Login</button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--@endsection--}}

@extends('layouts.app')
@section('content')
    <form method="POST" action="/users/authenticate">
        @csrf

        <div class="mb-6 px-4 rounded">
            <label for="email" class="inline-block text-lg text-dark mb-2 font font-bold">Email</label>
            <input type="email" class="border-4 border-medium rounded p-2 w-full bg-light" id="email" name="email" value="{{ old('email') }}"/>
            @error('email')
            <p class="text-dark text-xs mt-1 font font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 px-4 rounded">
            <label for="password" class="inline-block text-lg text-dark mb-2 font font-bold">Password</label>
            <input type="password" class="border-4 border-medium rounded p-2 w-full bg-light" id="password" name="password" value="{{ old('password') }}"/>
            @error('password')
            <p class="text-dark text-xs mt-1 font font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 px-4 rounded">
            <button type="submit" class="bg-medium text-dark rounded py-2 px-4 hover:bg-extra-light font font-bold">Sign In</button>
        </div>

        <div class="mt-8 px-4 rounded">
            <p class="font font-bold px-2 text-dark text-lg">Don't have an account?
                <a href="/register" class="text-dark font font-bold">Register</a>
            </p>
        </div>
    </form>
@endsection
