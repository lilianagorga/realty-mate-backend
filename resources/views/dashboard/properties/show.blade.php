@extends('dashboard.layout')

@section('dashboard-content')
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold text-green-600 text-center">{{ $property->title }}</h1>

        <div class="mt-20">
            <h2 class="text-2xl font-semibold mb-4 text-center text-beige-600">Details</h2>
            <p class="text-lg text-center text-beige-600">{{ $property->description }}</p>
            <p class="text-lg text-center text-beige-600">Price: €{{ $property->price }}</p>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('dashboard.properties.index') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Back</a>
        </div>
    </div>
@endsection
