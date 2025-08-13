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
            $page->fill($request->only([
                'header_title',
                'header_description',
                'title_1',
                'content_1',
                'title_2',
                'content_2',
                'title_3',
                'content_3',
                'title_4',
                'content_4',
                'green_title',
                'green_description',
                'footer_title',
                'footer_contact',
                'footer_description'
            ]));

            // Upload single content images
            foreach ([1, 2, 3, 4] as $i) {
                $field = "content_{$i}_image";
                if ($request->hasFile($field)) {
                    $path = $request->file($field)->store('content_images', 'public');
                    $page->$field = $path;
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

            // Transform to full URLs before returning
            foreach ([1, 2, 3, 4] as $i) {
                $field = "content_{$i}_image";
                if ($page->$field) {
                    $page->$field = asset('storage/' . $page->$field);
                }
            }

            if ($page->sliders) {
                $sliders = json_decode($page->sliders, true);
                $page->sliders = array_map(function ($path) {
                    return asset('storage/' . $path);
                }, $sliders);
            }

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


    public function showByParent($parentPage)
    {
        $page = Page::where('parent_page', $parentPage)->first();

        if (!$page) {
            return response()->json([
                'status' => false,
                'message' => 'Page not found'
            ], 404);
        }

        // Convert image paths to full URLs
        foreach ([1, 2, 3, 4] as $i) {
            $field = "content_{$i}_image";
            if ($page->$field) {
                $page->$field = asset('storage/' . $page->$field);
            }
        }

        if ($page->sliders) {
            $sliders = json_decode($page->sliders, true);
            $page->sliders = array_map(function ($path) {
                return asset('storage/' . $path);
            }, $sliders);
        }

        return response()->json([
            'status' => true,
            'data' => $page
        ]);
    }
}
