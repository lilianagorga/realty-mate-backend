@extends('dashboard.layout')

@section('dashboard-content')
    <div class="container mx-auto p-4">
        <div class="mb-4">
            <a href="{{ route('dashboard.testimonials.index') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Back to Testimonials</a>
        </div>
        <div class="bg-beige-200 border border-green-600 rounded-lg shadow-sm p-4">
            <h1 class="text-4xl font-bold text-green-600 text-center mb-4">{{ $testimonial->name }}</h1>
            <div class="flex justify-center mb-4">
                <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}" class="w-32 h-32 rounded-full shadow-md">
            </div>
            <div class="text-center">
                <p class="text-lg text-green-700"><strong>Company:</strong> {{ $testimonial->company }}</p>
                <p class="mt-4 text-beige-600">{{ $testimonial->testimonial }}</p>
            </div>
        </div>
    </div>
@endsection
