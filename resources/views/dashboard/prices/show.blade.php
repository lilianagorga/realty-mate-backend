@extends('dashboard.layout')

@section('dashboard-content')
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold text-green-600 text-center">Price Details</h1>
        <div class="mt-4 max-w-lg mx-auto">
            <div class="form-group mb-4">
                <label for="plan" class="block text-sm font-medium text-beige-600">Plan</label>
                <p class="mt-1 block w-full bg-beige-200 text-green-700 text-center">{{ $price->plan }}</p>
            </div>
            <div class="form-group mb-4">
                <label for="price" class="block text-sm font-medium text-beige-600">Price</label>
                <p class="mt-1 block w-full bg-beige-200 text-green-700 text-center">{{ $price->price }}</p>
            </div>
            <div class="form-group mb-4">
                <label for="ptext" class="block text-sm font-medium text-beige-600">Ptext</label>
                <p class="mt-1 block w-full bg-beige-200 text-green-700 text-center">{{ $price->ptext }}</p>
            </div>
            <div class="form-group mb-4">
                <label for="features" class="block text-sm font-medium text-beige-600">Features</label>
                <ul class="mt-1 block w-full bg-beige-200 text-green-700 text-center list-disc list-inside">
                    @foreach($price->features as $feature)
                        <li>{{ json_decode($feature->icon) }} {{ $feature->text }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('dashboard.prices.index') }}" class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Back</a>
            </div>
        </div>
    </div>
@endsection
