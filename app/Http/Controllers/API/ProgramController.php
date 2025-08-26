<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    // all the programs
    public function index()
    {
        return response()->json(Program::with('reviews')->get());
    }

    // shows individual programs

    public function show($slug)
    {
        $program = Program::where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'message' => 'Program fetched successfully.',
            'data' => [
                'id' => $program->id,
                'title' => $program->title,
                'slug' => $program->slug,
                'image' => $program->image ? asset('storage/' . $program->image) : null,
                'content' => $program->content,
                'description' => $program->description,
                'learning_outcomes' => $program->learning_outcomes,
                'course_fee' => $program->course_fee
                    ? number_format($program->course_fee, 2)
                    : null,
                'target_audience' => $program->target_audience,
                'entry_requirement' => $program->entry_requirement,
                'curriculum' => $program->curriculum,
                'course_content' => $program->course_content,
                'learning_experience' => $program->learning_experience,
                'news' => $program->news,
                'training_days' => $program->training_days,
                'start_date' => $program->start_date ? $program->start_date->toDateString() : null,
                'end_date' => $program->end_date ? $program->end_date->toDateString() : null,
                // 'reviews' => $program->reviews
            ]
        ], 200);
    }


    // save new programs
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|array',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'learning_outcomes' => 'nullable|array',
            'course_fee' => 'nullable|decimal:0,2',
            'target_audience' => 'nullable|string',
            'entry_requirement' => 'nullable|array',
            'curriculum' => 'nullable|array',
            'course_content' => 'nullable|array',
            'learning_experience' => 'nullable|array',
            'news' => 'boolean',
            'training_days' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('programs', 'public');
            }

            $program = Program::create($validated);

            // Ensure image_url is loaded
            $program->refresh();

            return response()->json([
                'status' => true,
                'message' => 'Program created successfully.',
                'data' => $program
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'The slug has already been created. Please choose another title and another parent_page.',
                // 'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $slug)
    {
        $program = Program::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'nullable|array',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'learning_outcomes' => 'nullable|array',
            'course_fee' => 'nullable|decimal:0,2',
            'target_audience' => 'nullable|string',
            'entry_requirement' => 'nullable|array',
            'curriculum' => 'nullable|array',
            'course_content' => 'nullable|array',
            'learning_experience' => 'nullable|array',
            'news' => 'boolean',
            'training_days' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('programs', 'public');
            }

            $program->update($validated);

            // Ensure image_url is loaded
            $program->refresh();

            return response()->json([
                'status' => true,
                'message' => 'Program updated successfully.',
                'data' => $program
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred while updating the program.',
                // 'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($slug)
    {
        Program::where('slug', $slug)->firstOrFail()->delete();
        return response()->json(['message' => 'Program deleted successfully']);
    }
}
