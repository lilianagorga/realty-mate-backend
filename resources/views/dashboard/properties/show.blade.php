@extends('dashboard.layout')

@section('dashboard-content')
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold text-green-600 text-center">{{ $property->title }}</h1>

        <div class="mt-20">
            <h2 class="text-2xl font-semibold mb-4 text-center text-beige-600">Details</h2>
            <p class="text-lg text-center text-beige-600">{{ $property->description }}</p>
            <p class="text-lg text-center text-beige-600">Price: €{{ $property->price }}</p>
        </div>
    </div>
@endsection
