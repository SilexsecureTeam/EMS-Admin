<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email|exists:users,email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your email or password is incorrect',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Password is wrong',
                ], 401);
            }

            // Generate OTP
            $otp = rand(1000, 9999);
            $expiresAt = now()->addMinutes(2);

            // Save OTP and expiry to user
            $user->update([
                'otp_code'       => $otp,
                'otp_expires_at' => $expiresAt,
            ]);

            // Send email
            Mail::raw("Your OTP code is: {$otp}", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your OTP Code');
            });

            return response()->json([
                'status'  => true,
                'message' => 'OTP sent to your email. Please verify to continue.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred during login.',
                'error' => $e->getMessage(), // Log or hide in production
            ], 500);
        }
    }


    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|digits:4',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = User::where('otp_code', $request->otp)
                ->where('otp_expires_at', '>', now())
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired OTP',
                ], 401);
            }

            // Clear OTP
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            // Authenticate or create token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status'  => true,
                'message' => 'Login successful. Redirecting...',
                'token'   => $token,
                'user'    => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred during OTP verification.',
                'error' => $e->getMessage(), // Hide this in production
            ], 500);
        }
    }


    public function sendResetLink(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return response()->json([
                'status' => $status === Password::RESET_LINK_SENT,
                'message' => __($status),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while sending the reset link.',
                'error' => $e->getMessage(), // Remove this in production if needed
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);

            // Get email and token from query string
            $email = $request->query('email');
            $token = $request->query('token');

            if (!$email || !$token) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token and email are required in the query string.',
                ], 422);
            }

            $status = Password::reset(
                [
                    'email' => $email,
                    'password' => $request->password,
                    'password_confirmation' => $request->password_confirmation,
                    'token' => $token,
                ],
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();
                }
            );

            return response()->json([
                'status' => $status === Password::PASSWORD_RESET,
                'message' => __($status),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while resetting the password.',
                'error' => $e->getMessage(), // optional: remove in production
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully.'
        ]);
    }
}
