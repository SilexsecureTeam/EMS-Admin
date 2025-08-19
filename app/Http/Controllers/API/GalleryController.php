<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'gallery_header' => 'required|string|max:255',
                'sub_header'     => 'nullable|string|max:255',
                'title'          => 'required|string|max:255',
                'image1'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'image2'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'image3'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = $validated;

            foreach (['image1', 'image2', 'image3'] as $imageField) {
                if ($request->hasFile($imageField)) {
                    $data[$imageField] = $request->file($imageField)->store('gallery', 'public');
                }
            }

            $gallery = Gallery::create($data);

            return response()->json([
                'status'  => true,
                'message' => 'Gallery item created successfully.',
                'data'    => $gallery
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while creating the gallery item.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::debug('updatedebug', ['request' => $request]);
        try {
            $gallery = Gallery::findOrFail($id);

            $validated = $request->validate([
                'gallery_header' => 'sometimes|string|max:255',
                'sub_header'     => 'nullable|string|max:255',
                'title'          => 'sometimes|string|max:255',
                'image1'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'image2'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'image3'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = $validated;

            foreach (['image1', 'image2', 'image3'] as $imageField) {
                if ($request->hasFile($imageField)) {
                    // Delete old file if exists
                    if ($gallery->$imageField && Storage::disk('public')->exists($gallery->$imageField)) {
                        Storage::disk('public')->delete($gallery->$imageField);
                    }
                    // Store new file
                    $data[$imageField] = $request->file($imageField)->store('gallery', 'public');
                }
            }

            $gallery->update($data);

            return response()->json([
                'status'  => true,
                'message' => 'Gallery item updated successfully.',
                'data'    => $gallery
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while updating the gallery item.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $galleries = Gallery::latest()->get();

        return response()->json([
            'status'  => true,
            'message' => 'Gallery list retrieved successfully.',
            'data'    => $galleries
        ]);
    }

    public function show($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);

            return response()->json([
                'status'  => true,
                'message' => 'Gallery item retrieved successfully.',
                'data'    => $gallery
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gallery item not found.',
                'error'   => $e->getMessage()
            ], 404);
        }
    }
}
