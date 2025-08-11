<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $career = Career::latest()->first();

        if (!$career) {
            return response()->json([
                'status'  => false,
                'message' => 'No career post found.',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Career post retrieved successfully.',
            'data'    => $career
        ], 200);
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'title'            => 'required|string|max:255',
                'content'          => 'required|string',
                'placement_header' => 'nullable|string|max:255',
                'email'            => 'required|email|max:255',
            ]);

            // Find the first career record
            $career = Career::first();

            if ($career) {
                $career->update($validated);
                $message = 'Career post updated successfully.';
            } else {
                $career = Career::create($validated);
                $message = 'Career post created successfully.';
            }

            return response()->json([
                'status'  => true,
                'message' => $message,
                'data'    => $career
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while saving the career post.',
                'error'   => $e->getMessage(),
                'data'    => null
            ], 500);
        }
    }

    // public function destroy($id)
    // {
    //     $career = Career::findOrFail($id);
    //     $career->delete();

    //     return response()->json(['message' => 'Career post deleted successfully']);
    // }
}
