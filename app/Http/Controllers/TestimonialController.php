<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class TestimonialController extends Controller
{
    public function index(Request $request): JsonResponse | View
    {
        $testimonials = Testimonial::all();

        if ($request->wantsJson()) {
            return response()->json($testimonials, Response::HTTP_OK);
        }

        return view('dashboard.testimonials.index', compact('testimonials'));

    }

    public function store(Request $request): JsonResponse| RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'company' => 'required',
            'testimonial' => 'required',
        ]);

        $data = $request->all();
        $data['image'] = $this->getDefaultImage();
        $testimonial = Testimonial::create($data);

        if ($request->wantsJson()) {
            return response()->json($testimonial, Response::HTTP_CREATED);
        }

        return redirect()->route('dashboard.testimonials.create')->with('success', 'Testimonial created successfully');
    }

    public function create(): View
    {
        return view('dashboard.testimonials.create');
    }


    public function show($id): JsonResponse|View
    {
        $testimonial = Testimonial::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($testimonial);
        }

        return view('dashboard.testimonials.show', compact('testimonial'));
    }

    public function edit($id): View
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('dashboard.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, $id): JsonResponse|RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'company' => 'required',
            'testimonial' => 'required',
        ]);

        $testimonial = Testimonial::findOrFail($id);
        $data = $request->all();
        $data['image'] = $testimonial->image ?? $this->getDefaultImage();
        $testimonial->update($data);

        if ($request->wantsJson()) {
            return response()->json($testimonial);
        }

        return redirect()->route('dashboard.testimonials.edit', ['id' => $id])->with('success', 'Testimonial updated successfully');
    }

    public function destroy($id): JsonResponse|RedirectResponse
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('dashboard.testimonials.index')->with('success', 'Testimonial deleted successfully');
    }

    private function getDefaultImage(): string
    {
        $defaultImages = config('testimonials_data.default_images');
        return $defaultImages[array_rand($defaultImages)];
    }
}
