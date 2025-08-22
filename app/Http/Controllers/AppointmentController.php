<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function showRegistration()
    {
        return view('appointment.registration');
    }
    
    public function showBookingDetails()
    {
        $appointmentData = Session::get('appointment_data');
        if (!$appointmentData) {
            return redirect()->route('appointment.registration')->with('error', 'Please complete the registration first.');
        }
        
        return view('appointment.booking-details');
    }
    
    public function showPayment()
    {
        $appointmentData = Session::get('appointment_data');
        $bookingData = Session::get('booking_data');
        
        if (!$appointmentData || !$bookingData) {
            return redirect()->route('appointment.registration')->with('error', 'Please complete all previous steps.');
        }
        
        // Calculate appointment fee (example pricing)
        $fee = $this->calculateAppointmentFee($bookingData['appointment_type'] ?? 'consultation');
        
        return view('appointment.payment', compact('fee'));
    }
    
    public function storeRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:appointments,email',
            'phone_code' => 'required|string',
            'mobile_number' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'terms_conditions' => 'required|array',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Create user account if it doesn't exist
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
        }
        
        // Log in the user
        Auth::login($user);
        
        // Store data in session for multi-step form
        Session::put('appointment_data', [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_code' => $request->phone_code,
            'mobile_number' => $request->mobile_number,
            'password' => $request->password,
            'terms_conditions' => $request->terms_conditions,
        ]);
        
        return redirect()->route('appointment.booking-details')->with('success', 'Registration data saved. Please continue with booking details.');
    }
    
    public function storeBookingDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_type' => 'required|string',
            'symptoms' => 'nullable|string',
            'preferred_doctor' => 'nullable|string',
            'preferred_time' => 'nullable|string',
            'preferred_date' => 'nullable|date|after:today',
            'additional_notes' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'current_medications' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Store booking data in session
        Session::put('booking_data', [
            'appointment_type' => $request->appointment_type,
            'symptoms' => $request->symptoms,
            'preferred_doctor' => $request->preferred_doctor,
            'preferred_time' => $request->preferred_time,
            'preferred_date' => $request->preferred_date,
            'additional_notes' => $request->additional_notes,
            'medical_history' => $request->medical_history,
            'current_medications' => $request->current_medications,
        ]);
        
        return redirect()->route('appointment.payment')->with('success', 'Booking details saved. Please proceed to payment.');
    }
    
    public function processPayment(Request $request)
    {
        $appointmentData = Session::get('appointment_data');
        $bookingData = Session::get('booking_data');
        
        if (!$appointmentData || !$bookingData) {
            return redirect()->route('appointment.registration')->with('error', 'Session expired. Please start again.');
        }
        
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:stripe,paypal',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Calculate fee
        $fee = $this->calculateAppointmentFee($bookingData['appointment_type']);
        
        // Create appointment record
        $appointment = Appointment::create(array_merge(
            $appointmentData,
            $bookingData,
            [
                'appointment_fee' => $fee,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending'
            ]
        ));
        
        // Store appointment ID in session for payment processing
        Session::put('appointment_id', $appointment->id);
        
        // Redirect to payment processor
        if ($request->payment_method === 'stripe') {
            return redirect()->route('payment.stripe');
        } else {
            return redirect()->route('payment.paypal');
        }
    }
    
    public function success()
    {
        $appointmentId = Session::get('appointment_id');
        if (!$appointmentId) {
            return redirect()->route('appointment.registration');
        }
        
        $appointment = Appointment::find($appointmentId);
        
        // Clear session data
        Session::forget(['appointment_data', 'booking_data', 'appointment_id']);
        
        return view('appointment.success', compact('appointment'));
    }
    
    private function calculateAppointmentFee($appointmentType)
    {
        $fees = [
            'consultation' => 75.00,
            'follow_up' => 50.00,
            'specialist' => 150.00,
            'emergency' => 200.00,
        ];
        
        return $fees[$appointmentType] ?? 75.00;
    }
}
