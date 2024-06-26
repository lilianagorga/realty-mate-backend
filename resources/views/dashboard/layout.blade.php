@extends('layouts.app')

@section('content')
    <nav class="bg-beige-200 shadow-lg rounded-lg mb-8 py-4">
        <div class="container mx-auto px-8">
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-green-600 hover:text-green-700">Dashboard</a>
                <div class="flex items-center space-x-8">
                    @if (Auth::user()->can('manageProperties'))
                        <a href="{{ route('dashboard.properties.index') }}" class="text-green-600 hover:text-green-700">Properties</a>
                    @else
                        <a href="#" class="text-gray-400 cursor-not-allowed" title="You don't have permission to manage properties">Properties</a>
                    @endif
                    <a href="{{ route('dashboard.teams.index') }}" class="text-green-600 hover:text-green-700">Teams</a>

                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('dashboard.roles-permissions') }}" class="text-green-600 hover:text-green-700">Roles & Permissions</a>
                        @else
                            <a href="#" class="text-gray-400 cursor-not-allowed" title="You don't have permission to manage roles and Permissions">Roles & Permissions</a>
                    @endif

                    @if (Auth::user()->canManagePrice())
                        <a href="{{ route('dashboard.prices.index') }}" class="text-green-600 hover:text-green-700">Prices</a>
                    @else
                        <a href="#" class="text-gray-400 cursor-not-allowed" title="You don't have permission to manage prices">Prices</a>
                    @endif
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
