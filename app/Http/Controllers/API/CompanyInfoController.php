<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    public function index()
    {
        $info = CompanyInfo::first();

        if (!$info) {
            return response()->json([
                'status'  => false,
                'message' => 'No company info found.',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Company info retrieved successfully.',
            'data'    => $info
        ], 200);
    }

    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'address'        => 'required|string|max:255',
            'phone_numbers'  => 'required|array',
            'phone_numbers.*'=> 'string',
            'email'          => 'required|email|max:255',
        ]);

        $info = CompanyInfo::first();

        if ($info) {
            $info->update($validated);
            $message = 'Company info updated successfully.';
        } else {
            $info = CompanyInfo::create($validated);
            $message = 'Company info created successfully.';
        }

        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $info
        ], 200);
    }

    public function destroy()
    {
        $info = CompanyInfo::first();

        if (!$info) {
            return response()->json([
                'status'  => false,
                'message' => 'No company info found.',
                'data'    => null
            ], 404);
        }

        $info->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Company info deleted successfully.',
            'data'    => null
        ], 200);
    }
}
