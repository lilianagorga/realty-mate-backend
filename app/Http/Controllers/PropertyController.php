<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PropertyController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $user = $request->user();
        $properties = Property::where('user_id', $user->id)->get();

        foreach ($properties as $property) {
            $property->price = number_format((int)$property->price, 0, '', '.');
        }

        if ($request->wantsJson()) {
            return response()->json($properties);
        }

        return view('dashboard.properties.index', compact('properties'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|regex:/^\d{1,3}(\.\d{3})*$/',
        ]);

        $price = str_replace('.', '', $request->input('price'));

        $property = new Property([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => (int)$price,
            'user_id' => $request->user()->id,
        ]);
        $property->save();

        if ($request->wantsJson()) {
            $property->price = number_format($property->price, 0, '', '.');
            return response()->json($property, 201);
        }

        return redirect()->route('dashboard.properties.index')->with('success', 'Property created successfully');
    }

    public function show($id): JsonResponse|View
    {
        $property = Property::findOrFail($id);
        $property->price = number_format((int)$property->price, 0, '', '.');

        if (request()->wantsJson()) {
            return response()->json($property);
        }

        return view('dashboard.properties.show', compact('property'));
    }

    public function edit($id): View
    {
        $property = Property::findOrFail($id);
        $property->price = number_format((int)$property->price, 0, '', '.');
        return view('dashboard.properties.edit', compact('property'));
    }

    public function update(Request $request, $id): JsonResponse|RedirectResponse
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|regex:/^\d{1,3}(\.\d{3})*$/',
        ]);

        $property = Property::findOrFail($id);
        $data = $request->all();
        if (isset($data['price'])) {
            $price = str_replace('.', '', $data['price']);
            $data['price'] = (int)$price;
        }

        $property->update($data);


        if ($request->wantsJson()) {
            $property->price = number_format((int)$property->price, 0, '', '.');
            return response()->json($property);
        }

        return redirect()->route('dashboard.properties.index')->with('success', 'Property updated successfully');
    }

    public function destroy($id): JsonResponse|RedirectResponse
    {
        $property = Property::findOrFail($id);
        $property->delete();

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('dashboard.properties.index')->with('success', 'Property deleted successfully');
    }
}
