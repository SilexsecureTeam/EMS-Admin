<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EnrolNow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EnrolNowController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'header_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'title'        => 'required|string|max:255',
                'content'      => 'required|string',
                'pdf_file'     => 'nullable|mimes:pdf|max:5120',
            ]);

            // Get first record or create new instance
            $enrol = EnrolNow::first() ?? new EnrolNow();

            // Upload header image (delete old if exists)
            if ($request->hasFile('header_image')) {
                if ($enrol->header_image && Storage::disk('public')->exists($enrol->header_image)) {
                    Storage::disk('public')->delete($enrol->header_image);
                }
                $validated['header_image'] = $request->file('header_image')->store('enrol/header', 'public');
            }

            // Upload PDF file (delete old if exists)
            if ($request->hasFile('pdf_file')) {
                if ($enrol->pdf_file && Storage::disk('public')->exists($enrol->pdf_file)) {
                    Storage::disk('public')->delete($enrol->pdf_file);
                }
                $validated['pdf_file'] = $request->file('pdf_file')->store('enrol/pdfs', 'public');
            }

            $enrol->fill($validated)->save();

            return response()->json([
                'status'  => true,
                'message' => 'Data saved successfully',
                'data'    => $enrol
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to save data',
                // 'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function download($id)
    {
        try {
            $enrol = EnrolNow::findOrFail($id);

            if (!$enrol->pdf_file || !Storage::disk('public')->exists($enrol->pdf_file)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'PDF file not found'
                ], 404);
            }

            return response()->download(storage_path('app/public/' . $enrol->pdf_file));
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error downloading file',
                // 'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show()
    {
        $enrol = EnrolNow::first();

        if ($enrol) {
            $enrol->header_image = $enrol->header_image
                ? asset('storage/' . $enrol->header_image)
                : null;

            $enrol->pdf_file = $enrol->pdf_file
                ? asset('storage/' . $enrol->pdf_file)
                : null;
        }

        return response()->json($enrol);
    }
}
