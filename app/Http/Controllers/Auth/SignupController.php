<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupMail;


class SignupController extends Controller
{
    /**
     * Show the signup form
     */
    public function showSignupForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration and send email verification PIN
     */
 
    
     public function signup(Request $request)
     {
         try {
             $request->validate([
                 'firstname' => 'required|string|max:255',
                 'lastname' => 'required|string|max:255',
                 'email' => 'required|email|unique:users,email',
                 'phonenumber' => 'required|numeric',
                 'address' => 'required|string|max:255',
                 'city' => 'required|string|max:255',
                 'post_code' => 'required|string|max:10',
                 'password' => 'required|string|min:8',
             ]);
     
             $verificationPin = random_int(100000, 999999);
     
             $user = User::create([
                 'first_name' => $request->firstname,
                 'last_name' => $request->lastname,
                 'email' => $request->email,
                 'phone_number' => $request->phonenumber,
                 'address' => $request->address,
                 'city' => $request->city,
                 'post_code' => $request->post_code,
                 'password' => bcrypt($request->password),
                 'email_verification_pin' => $verificationPin,
             ]);
     
             Mail::to($user->email)->send(new SignupMail($verificationPin));
     
             return response()->json(['message' => 'Registration successful! Please verify your email.']);
         } catch (\Exception $e) {
             return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
         }
     }
     
    /**
     * Handle email verification
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pin' => 'required|numeric',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user || $user->email_verification_pin != $request->pin) {
            return response()->json(['message' => 'Invalid PIN or email.'], 422);
        }

        // Mark the email as verified
        $user->is_verified = true;
        $user->email_verification_pin = null; // Clear the PIN after successful verification
        $user->save();

        return response()->json(['message' => 'Email verified successfully!']);
    }
}
