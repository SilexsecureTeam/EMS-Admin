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
        $program = Program::with('reviews')->where('slug', $slug)->firstOrFail();
        return response()->json($program);
    }

    // save new programs
    public function store(Request $request)
    {
        // Validate first (Laravel will automatically return 422 on failure)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'learning_outcomes' => 'nullable|array',
            'course_fee' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'entry_requirement' => 'nullable|string',
            'curriculum' => 'nullable|array',
            'course_content' => 'nullable|string',
            'learning_experience' => 'nullable|string',
        ]);

        try {
            // Handle image upload if present
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('programs', 'public');
            }

            // Create program
            $program = Program::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Program created successfully.',
                'data' => $program
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // update program detail
    public function update(Request $request, $slug)
    {
        $program = Program::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'learning_outcomes' => 'nullable|array',
            'course_fee' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'entry_requirement' => 'nullable|string',
            'curriculum' => 'nullable|array',
            'course_content' => 'nullable|string',
            'learning_experience' => 'nullable|string',
        ]);
// dd($validated);
        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('programs', 'public');
            }

            $program->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Program updated successfully.',
                'data' => $program
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred while updating the program.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($slug)
    {
        Program::where('slug', $slug)->firstOrFail()->delete();
        return response()->json(['message' => 'Program deleted successfully']);
    }
}
