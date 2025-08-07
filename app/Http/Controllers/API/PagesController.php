<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        try {
            $request->validate([
                'parent_page' => 'required|string',
                'sliders.*' => 'nullable|image',
                'header_title' => 'nullable|string',
                'header_description' => 'nullable|string',
                'title_1' => 'nullable|string',
                'content_1' => 'nullable|string',
                'content_1_image' => 'nullable|image',
                'title_2' => 'nullable|string',
                'content_2' => 'nullable|string',
                'content_2_image' => 'nullable|image',
                'title_3' => 'nullable|string',
                'content_3' => 'nullable|string',
                'content_3_image' => 'nullable|image',
                'title_4' => 'nullable|string',
                'content_4' => 'nullable|string',
                'content_4_image' => 'nullable|image',
                'green_title' => 'nullable|string',
                'green_description' => 'nullable|string',
                'footer_title' => 'nullable|string',
                'footer_contact' => 'nullable|string',
                'footer_description' => 'nullable|string',
            ]);

            $page = Page::firstOrNew(['parent_page' => $request->parent_page]);

            // Update text fields
            $page->header_title = $request->header_title;
            $page->header_description = $request->header_description;
            $page->title_1 = $request->title_1;
            $page->content_1 = $request->content_1;
            $page->title_2 = $request->title_2;
            $page->content_2 = $request->content_2;
            $page->title_3 = $request->title_3;
            $page->content_3 = $request->content_3;
            $page->title_1 = $request->title_1;
            $page->content_1 = $request->content_1;
            $page->green_title = $request->green_title;
            $page->green_description = $request->green_description;
            $page->footer_title = $request->footer_title;
            $page->footer_contact = $request->footer_contact;
            $page->footer_description = $request->footer_description;


            // Upload image
            foreach ([1, 2, 3, 4] as $i) {
                $field = "content_{$i}_image";
                if ($request->hasFile($field)) {
                    $page->$field = $request->file($field)->store('content_images', 'public');
                }
            }

            // Upload multiple sliders
            if ($request->hasFile('sliders')) {
                $sliderPaths = [];
                foreach ($request->file('sliders') as $slider) {
                    $sliderPaths[] = $slider->store('sliders', 'public');
                }
                $page->sliders = json_encode($sliderPaths);
            }

            $page->save();

            return response()->json([
                'status' => true,
                'message' => 'Page saved successfully',
                'data' => $page
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while saving the page.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showByParent($parent_page)
    {
        try {
            $page = Page::where('parent_page', $parent_page)->first();

            if (!$page) {
                return response()->json([
                    'status' => false,
                    'message' => 'Page not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $page
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching the page.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
