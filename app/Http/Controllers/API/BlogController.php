<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Blog::with('author:id,firstname,lastname')->latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'status'       => 'required|in:draft,published',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'top_stories'  => 'nullable|boolean',
        ]);

        try {
            $data = $request->only(['title', 'content', 'status', 'top_stories']);
            $data['author_id'] = auth()->id();
            $data['slug'] = Str::slug($data['title']);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('blogs', 'public');
                $data['image'] = $path; // store relative path
            }

            $blog = Blog::create($data);

            // Return with full image URL
            $blog->image_url = $blog->image ? asset('storage/' . $blog->image) : null;

            return response()->json($blog, 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while creating the blog.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($slug)
    {
        $blog = Blog::with('author:id,firstname,lastname,email')
            ->where('slug', $slug)
            ->firstOrFail();

        // Append full image URL
        $blog->image_url = $blog->image ? asset('storage/' . $blog->image) : null;

        return response()->json($blog);
    }


    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'        => 'sometimes|string|max:255',
            'content'      => 'sometimes|string',
            'status'       => 'sometimes|in:draft,published',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'top_stories'  => 'nullable|boolean',
        ]);

        try {
            $data = $request->only(['title', 'content', 'status', 'top_stories']);

            if ($request->hasFile('image')) {
                // Delete old image
                if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                    Storage::disk('public')->delete($blog->image);
                }
                $path = $request->file('image')->store('blogs', 'public');
                $data['image'] = $path;
            }

            if (isset($data['title'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            $blog->update($data);

            // Return with full image URL
            $blog->image_url = $blog->image ? asset('storage/' . $blog->image) : null;

            return response()->json([
                'status'  => true,
                'message' => 'Blog updated successfully',
                'data'    => $blog
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to update blog',
                // 'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }

    public function topStories()
    {
        return response()->json(
            Blog::where('top_stories', true)
                ->where('status', 'published')
                ->latest()
                ->get()
        );
    }
}
