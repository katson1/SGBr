<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        $places = Place::query();

        if ($request->has('name')) {
            $places->where('name', 'like', '%' . $request->query('name') . '%');
        }

        return response()->json($places->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:places',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);

        $place = Place::create($validated);

        return response()->json($place, 201);
    }

    public function show($id)
    {
        $place = Place::findOrFail($id);

        return response()->json($place);
    }

    public function update(Request $request, $id)
    {
        $place = Place::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:places,slug,' . $place->id,
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
        ]);

        $place->update($validated);

        return response()->json($place);
    }

    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        $place->delete();

        return response()->json(null, 204);
    }
}