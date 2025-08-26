<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProgramReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //     public function index()
    // {
    //     // Only fetch reviews that are featured
    //     $reviews = ProgramReview::where('featured', true)->get();

    //     // Convert image paths to full URLs
    //     $reviews->transform(function ($review) {
    //         if ($review->image) {
    //             $review->image = asset('storage/' . $review->image);
    //         }
    //         return $review;
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'data' => $reviews
    //     ]);
    // }

    public function index()
    {
        $reviews = ProgramReview::where('featured', true)->get();

        return response()->json([
            'status' => true,
            'data' => $reviews
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'reviewer_name'  => 'required|string|max:255',
            'review'         => 'required|string',
            'rating'         => 'required|integer|min:1|max:5',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured'       => 'boolean',
        ]);

        $data = $request->only([
            'reviewer_name',
            'review',
            'rating',
            'featured',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        $review = ProgramReview::create($data);

        if ($review->image) {
            $review->image = asset('storage/' . $review->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Review added successfully',
            'data' => $review
        ]);
    }

    public function destroy($id)
    {
        $review = ProgramReview::findOrFail($id);
        $review->delete();

        return response()->json([
            'status' => true,
            'message' => 'Review deleted successfully'
        ]);
    }
}
