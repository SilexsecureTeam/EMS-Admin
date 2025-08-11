<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactNotification;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
     public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname'     => 'required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'email'         => 'required|email',
            'phone_number'  => 'required|string|max:20',
            'subject'       => 'required|string|max:500',
            'message'       => 'required|string|max:1000',
        ]);

        $contact = Contact::create($validated);

        // Send email to admin
        Mail::to('info@etiquettemanagementschool.com')->send(new ContactNotification($contact));

        return response()->json([
            'message' => 'Contact message sent successfully!',
            'data' => $contact
        ]);
    }

    public function index()
    {
        return response()->json(Contact::latest()->get());
    }
}
