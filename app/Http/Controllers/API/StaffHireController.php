<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\StaffHireConfirmation;
use App\Mail\StaffHireNotification;
use App\Models\StaffHire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StaffHireController extends Controller
{
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'          => 'required|string|max:255',
            'last_name'           => 'required|string|max:255',
            'email'               => 'required|email|max:255',
            'phone'               => 'required|string|max:20',
            'staff_category'      => 'required|string|max:255',
            'years_of_experience' => 'nullable|integer|min:0',
            'address'             => 'required|string|max:255',
            'city'                => 'required|string|max:255',
            'country'             => 'required|string|max:255',
            'zip_code'            => 'nullable|string|max:20',
            'interest_reason'     => 'required|string',
        ]);

        $staffHire = StaffHire::create($validated);

         Mail::to('info@etiquettemanagementschool.com')->send(new StaffHireNotification($staffHire));

         Mail::to($staffHire->email)->send(new StaffHireConfirmation($staffHire));
         
        return response()->json([
            'status'  => true,
            'message' => 'Application submitted successfully!',
            'data'    => $staffHire,
        ], 201);
    }

    
    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => StaffHire::latest()->get(),
        ]);
    }

    
    public function show($id)
    {
        $application = StaffHire::findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $application,
        ]);
    }

   
    public function destroy($id)
    {
        StaffHire::findOrFail($id)->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Application deleted successfully.',
        ]);
    }
}
