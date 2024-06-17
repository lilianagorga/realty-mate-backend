@extends('layouts.app')

@section('content')
    <nav class="bg-white shadow mb-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between">
                <div class="text-lg font-bold">Dashboard</div>
                <div>
                    <a href="{{ route('dashboard') }}" class="mr-4">Home</a>
                    <a href="{{ route('dashboard.create-role') }}" class="mr-4">Create Role</a>
                    <form method="POST" action="{{ route('logout.get') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div>
        @yield('dashboard-content')
    </div>
@endsection
