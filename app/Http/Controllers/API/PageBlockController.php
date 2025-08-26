<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PageBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageBlockController extends Controller
{
    public function index()
    {
        $block = PageBlock::latest()->first();

        if (!$block) {
            return response()->json([
                'status'  => false,
                'message' => 'No page block found.',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Page block retrieved successfully.',
            'data'    => [
                'id'          => $block->id,
                'header'      => $block->header,
                'sub_heading' => $block->sub_heading,
                'title1'      => $block->title1,
                'content1'    => $block->content1,
                'title2'      => $block->title2,
                'content2'    => $block->content2,
                'title3'      => $block->title3,
                'content3'    => $block->content3,
                'image'       => $block->image ? asset('storage/' . $block->image) : null,
                'created_at'  => $block->created_at,
                'updated_at'  => $block->updated_at,
            ]
        ], 200);
    }

    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'header'      => 'required|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'title1'      => 'nullable|string|max:255',
            'content1'    => 'nullable|string',
            'title2'      => 'nullable|string|max:255',
            'content2'    => 'nullable|string',
            'title3'      => 'nullable|string|max:255',
            'content3'    => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $block = PageBlock::first();

        if ($block) {
            // Handle image replacement
            if ($request->hasFile('image')) {
                if ($block->image) {
                    Storage::disk('public')->delete($block->image);
                }
                $validated['image'] = $request->file('image')->store('page-blocks', 'public');
            }

            $block->update($validated);
            $message = 'Page block updated successfully.';
        } else {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('page-blocks', 'public');
            }
            $block = PageBlock::create($validated);
            $message = 'Page block created successfully.';
        }

        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $block
        ], 200);
    }

    public function destroy()
    {
        $block = PageBlock::first();

        if (!$block) {
            return response()->json([
                'status'  => false,
                'message' => 'No page block found to delete.',
            ], 404);
        }

        if ($block->image) {
            Storage::disk('public')->delete($block->image);
        }

        $block->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Page block deleted successfully.',
        ], 200);
    }
}
