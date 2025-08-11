<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        return response()->json(Career::latest()->first());
    }

    public function show($id)
    {
        return response()->json(Career::findOrFail($id));
    }

    public function store(Request $request)
    {
        try {
            // Check if a career entry already exists
            if (Career::exists()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Only one career record is allowed.'
                ], 422);
            }

            $validated = $request->validate([
                'title'            => 'required|string|max:255',
                'content'          => 'required|string',
                'placement_header' => 'nullable|string|max:255',
                'email'            => 'required|email|max:255',
            ]);

            $career = Career::create($validated);

            return response()->json($career, 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while creating the career post.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $career = Career::findOrFail($id);

            $validated = $request->validate([
                'title'            => 'sometimes|string|max:255',
                'content'          => 'sometimes|string',
                'placement_header' => 'nullable|string|max:255',
                'email'            => 'sometimes|email|max:255',
            ]);

            $career->update($validated);

            return response()->json($career);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while updating the career post.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $career = Career::findOrFail($id);
        $career->delete();

        return response()->json(['message' => 'Career post deleted successfully']);
    }
}
