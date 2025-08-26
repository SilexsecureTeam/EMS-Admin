<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|string|max:255',
                'lastname'  => 'required|string|max:255',
                'email'     => 'required|email|unique:users,email',
                'phone'     => 'required|string|max:15|unique:users,phone',
                'password'  => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation error',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $user = User::create([
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'password'  => Hash::make($request->password),
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'User registered successfully',
                'user'    => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred during registration.',
                'error'   => $e->getMessage(), // You can hide this in production
            ], 500);
        }
    }

   public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,' . $user->id,
            'role'     => 'sometimes|string|in:user,superadmin',
            'password' => 'sometimes|string|min:8|confirmed', 
            // requires password_confirmation field
        ]);

        // If password exists, hash it before saving
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'User detail updated successfully',
            'data'    => $user,
        ]);
    }

    public function index()
{
    $users = User::latest()->get();

    return response()->json([
        'status' => true,
        'data'   => $users,
    ]);
}
}
