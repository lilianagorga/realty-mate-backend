@extends('layouts.app')

@section('content')
    <nav class="bg-beige-200 shadow-lg rounded-lg mb-8 py-4">
        <div class="container mx-auto px-8">
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-green-600">Dashboard</a>
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-green-600 hover:text-green-700">Home</a>
                    <a href="{{ route('dashboard.properties.index') }}" class="text-green-600 hover:text-green-700">Properties</a>
                    <a href="{{ route('dashboard.teams.index') }}" class="text-green-600 hover:text-green-700">Teams</a>
                    <form method="POST" action="{{ route('logout.get') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center text-red-600 hover:text-red-700">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div>
        @yield('dashboard-content')
    </div>
@endsection
