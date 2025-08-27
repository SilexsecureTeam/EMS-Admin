<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ValueController extends Controller
{
    public function index()
    {
        return response()->json(Value::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon'     => 'nullable|string|max:255',
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'featured' => 'boolean',
        ]);

        $value = Value::create($data);

        return response()->json($value, 201);
    }


    public function show(Value $value)
    {
        return response()->json($value);
    }

    public function update(Request $request, Value $value)
    {
        $data = $request->validate([
            'icon'     => 'sometimes|required|string|max:255',
            'title'    => 'sometimes|required|string|max:255',
            'content'  => 'sometimes|required|string',
            'featured' => 'boolean',
        ]);

        $value->update($data);

        return response()->json($value);
    }


    public function destroy(Value $value)
    {
        $value->delete();
        return response()->json([
            'message' => 'deleted successfully',
        ]);
    }
}
