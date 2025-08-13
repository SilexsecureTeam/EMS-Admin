<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // image validation
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('careers', 'public');
                $validated['image'] = asset('storage/' . $path); // full public URL
            }

            // Find the first career record
            $career = Career::first();

            if ($career) {
                if ($request->hasFile('image') && $career->image) {
                    Storage::disk('public')->delete($career->image);
                }

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
