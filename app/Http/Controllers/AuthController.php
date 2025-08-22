<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showSignIn()
    {
        return view('auth.signin');
    }
    
    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Check if user exists in users table
        $user = User::where('email', $request->email)->first();
        
        if ($user && Hash::check($request->password, $user->password)) {
            // User exists in users table - authenticate them
            Auth::login($user);
            
            // Check if they have existing appointments
            $appointment = Appointment::where('email', $request->email)->latest()->first();
            
            if ($appointment) {
                // User has existing appointments - redirect to booking details
                Session::put('appointment_data', [
                    'full_name' => $appointment->full_name,
                    'email' => $appointment->email,
                    'phone_code' => $appointment->phone_code,
                    'mobile_number' => $appointment->mobile_number,
                    'password' => $request->password, // Store plain password for session
                    'terms_conditions' => $appointment->terms_conditions,
                ]);
                
                return redirect()->route('appointment.booking-details')
                    ->with('success', 'Welcome back! Please update your appointment details.');
            } else {
                // User exists but no appointments - redirect to booking details
                Session::put('appointment_data', [
                    'full_name' => $user->name,
                    'email' => $user->email,
                    'phone_code' => '+1', // Default
                    'mobile_number' => '',
                    'password' => $request->password,
                    'terms_conditions' => ['privacy' => '1', 'marketing' => '1'],
                ]);
                
                return redirect()->route('appointment.booking-details')
                    ->with('success', 'Welcome back! Please complete your appointment details.');
            }
        }
        
        // Check if user exists in appointments table (for users who registered through appointment form)
        $appointment = Appointment::where('email', $request->email)->first();
        
        if ($appointment && Hash::check($request->password, $appointment->password)) {
            // User exists in appointments table - create user account if doesn't exist
            if (!$user) {
                $user = User::create([
                    'name' => $appointment->full_name,
                    'email' => $appointment->email,
                    'password' => $appointment->password,
                ]);
            }
            
            Auth::login($user);
            
            // Store appointment data in session
            Session::put('appointment_data', [
                'full_name' => $appointment->full_name,
                'email' => $appointment->email,
                'phone_code' => $appointment->phone_code,
                'mobile_number' => $appointment->mobile_number,
                'password' => $request->password,
                'terms_conditions' => $appointment->terms_conditions,
            ]);
            
            return redirect()->route('appointment.booking-details')
                ->with('success', 'Welcome back! Please update your appointment details.');
        }
        
        // Invalid credentials
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
    
    public function signOut()
    {
        Auth::logout();
        Session::flush();
        
        return redirect()->route('appointment.registration')
            ->with('success', 'You have been successfully signed out.');
    }
    
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
    
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Check if user exists
        $user = User::where('email', $request->email)->first();
        $appointment = Appointment::where('email', $request->email)->first();
        
        if (!$user && !$appointment) {
            return back()->withErrors([
                'email' => 'We could not find a user with that email address.',
            ])->withInput();
        }
        
        // For now, just show a success message
        // In a real application, you would send a password reset email
        return back()->with('success', 'If a user with that email address exists, we have sent a password reset link.');
    }
}
