<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function index()
    {
        return response()->json(Bike::all());
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $bike = Bike::create($validated);

        return response()->json($bike, 201);
    }

    public function show(Bike $bike)
    {
        return response()->json($bike);
    }

    public function update(Request $request, Bike $bike)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $bike->update($validated);

        return response()->json($bike);
    }

    public function destroy(Bike $bike)
    {
        $bike->delete();

        return response(null, 204);
    }
}
