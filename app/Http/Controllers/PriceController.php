<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriceController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $prices = Price::with('features')->get();

        if ($request->wantsJson()) {
            return response()->json($prices);
        }

        return view('dashboard.prices.index', compact('prices'));
    }

    public function store(Request $request): JsonResponse | RedirectResponse
    {
        $request->validate([
            'plan' => 'required|string|max:255',
            'price' => 'required|numeric',
            'ptext' => 'required|string',
        ]);

        $price = Price::create($request->only(['plan', 'price', 'ptext']));

        $defaultFeatures = [
            ['icon' => json_encode('<i class="fa-solid fa-check"></i>'), 'text' => 'Default Feature 1'],
            ['icon' => json_encode('<i class="fa-solid fa-check"></i>'), 'text' => 'Default Feature 2'],
            ['icon' => json_encode('<i class="fa-solid fa-x"></i>'), 'text' => 'Default Feature 3'],
        ];

        foreach ($defaultFeatures as $feature) {
            $price->features()->create($feature);
        }

        if ($request->wantsJson()) {
            return response()->json($price->load('features'), 201);
        }

        return redirect()->route('dashboard.prices.create')->with('success', 'Price created successfully');
    }

    public function show($id): JsonResponse|View
    {
        $price = Price::with('features')->findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($price);
        }

        return view('dashboard.prices.show', compact('price'));
    }

    public function create(): View
    {
        return view('dashboard.prices.create');
    }

    public function edit($id): View
    {
        $price = Price::with('features')->findOrFail($id);
        return view('dashboard.prices.edit', compact('price'));
    }


    public function update(Request $request, $id): JsonResponse|RedirectResponse
    {
        $request->validate([
            'plan' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'ptext' => 'sometimes|string',
        ]);

        $price = Price::findOrFail($id);
        $price->update($request->only(['plan', 'price', 'ptext']));

        if ($request->wantsJson()) {
            return response()->json($price->load('features'));
        }

        return redirect()->route('dashboard.prices.edit', $price->id)->with('success', 'Price updated successfully');
    }

    public function destroy($id): JsonResponse | RedirectResponse
    {
        $price = Price::with('features')->findOrFail($id);
        $price->delete();

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('dashboard.prices.index')->with('success', 'Price deleted successfully');
    }
}
