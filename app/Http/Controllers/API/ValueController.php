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
            'icon'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'featured' => 'boolean',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('values', 'public');
        }

        $value = Value::create($data);

        // Append full URL before returning
        if ($value->icon) {
            $value->icon = asset('storage/' . $value->icon);
        }

        return response()->json($value, 201);
    }


    public function show(Value $value)
    {
        return response()->json($value);
    }

    public function update(Request $request, Value $value)
    {
        $data = $request->validate([
            'icon'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title'    => 'sometimes|required|string|max:255',
            'content'  => 'sometimes|required|string',
            'featured' => 'boolean',
        ]);

        if ($request->hasFile('icon')) {
            // delete old icon
            if ($value->icon && Storage::disk('public')->exists($value->icon)) {
                Storage::disk('public')->delete($value->icon);
            }

            $data['icon'] = $request->file('icon')->store('values', 'public');
        }

        $value->update($data);

        if ($value->icon) {
            $value->icon = asset('storage/' . $value->icon);
        }

        return response()->json($value);
    }


    public function destroy(Value $value)
    {
        $value->delete();
        return response()->json([
            'message'=> 'deleted successfully',
        ]);
    }
}
