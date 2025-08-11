<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EnrolNow;
use Illuminate\Http\Request;

class EnrolNowController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'pdf_file'     => 'nullable|mimes:pdf|max:5120',
        ]);

        // Get first record or create new instance
        $enrol = EnrolNow::first() ?? new EnrolNow();

        // Upload header image
        if ($request->hasFile('header_image')) {
            $validated['header_image'] = $request->file('header_image')->store('enrol/header', 'public');
        }

        // Upload PDF file
        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('enrol/pdfs', 'public');
        }

        $enrol->fill($validated)->save();

        return response()->json([
            'message' => 'Data saved successfully',
            'data' => $enrol,
            // 'download_link' => asset('storage/' . $enrol->pdf_file)
        ]);
        // return response()->json([
        //     'message' => 'Data saved successfully',
        //     'data' => $enrol,
        //     'download_link' => asset('storage/' . $enrol->pdf_file)
        // ]);
    }

    public function download($id)
    {
        $enrol = EnrolNow::findOrFail($id);

        if (!$enrol->pdf_file || !file_exists(storage_path('app/public/' . $enrol->pdf_file))) {
            return response()->json([
                'message' => 'PDF file not found'
            ], 404);
        }

        return response()->download(storage_path('app/public/' . $enrol->pdf_file));
    }

    public function show()
    {
        return response()->json(EnrolNow::first());
    }
}
