<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return Property::where('user_id', $user->id)->get();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $property = new Property($request->only('title', 'description', 'price'));
        $property->user_id = $request->user()->id;
        $property->save();

        return response()->json($property, 201);
    }

    public function show($id):JsonResponse
    {
        $property = Property::findOrFail($id);

        return response()->json($property);
    }

    public function update(Request $request, $id):JsonResponse
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
        ]);

        $property = Property::findOrFail($id);
        $property->update($request->all());

        return response()->json($property);
    }

    public function destroy($id):JsonResponse
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return response()->json(null, 204);
    }
}
