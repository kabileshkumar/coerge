<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function processStripe(Request $request)
    {
        $appointmentId = Session::get('appointment_id');
        if (!$appointmentId) {
            return redirect()->route('appointment.registration')->with('error', 'Session expired.');
        }
        
        $appointment = Appointment::find($appointmentId);
        if (!$appointment) {
            return redirect()->route('appointment.registration')->with('error', 'Appointment not found.');
        }
        
        return view('payment.stripe', compact('appointment'));
    }
    
    public function handleStripePayment(Request $request)
    {
        $appointmentId = Session::get('appointment_id');
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
        
        try {
            // Test mode - simulate successful payment
            if (env('APP_ENV') === 'local') {
                $appointment->update([
                    'payment_status' => 'completed',
                    'payment_transaction_id' => 'test_' . uniqid(),
                    'status' => 'confirmed'
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Payment processed successfully (Test Mode)',
                    'redirect_url' => route('appointment.success')
                ]);
            }
            
            // Here you would integrate with actual Stripe API
            // This is a placeholder for real implementation
            
            return response()->json(['error' => 'Payment processing not implemented for production'], 500);
            
        } catch (\Exception $e) {
            Log::error('Stripe payment error: ' . $e->getMessage());
            return response()->json(['error' => 'Payment processing failed'], 500);
        }
    }
    
    public function processPayPal(Request $request)
    {
        $appointmentId = Session::get('appointment_id');
        if (!$appointmentId) {
            return redirect()->route('appointment.registration')->with('error', 'Session expired.');
        }
        
        $appointment = Appointment::find($appointmentId);
        if (!$appointment) {
            return redirect()->route('appointment.registration')->with('error', 'Appointment not found.');
        }
        
        return view('payment.paypal', compact('appointment'));
    }
    
    public function handlePayPalPayment(Request $request)
    {
        $appointmentId = Session::get('appointment_id');
        $appointment = Appointment::find($appointmentId);
        
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
        
        try {
            // Test mode - simulate successful payment
            if (env('APP_ENV') === 'local') {
                $appointment->update([
                    'payment_status' => 'completed',
                    'payment_transaction_id' => 'paypal_test_' . uniqid(),
                    'status' => 'confirmed'
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'PayPal payment processed successfully (Test Mode)',
                    'redirect_url' => route('appointment.success')
                ]);
            }
            
            // Here you would integrate with actual PayPal API
            // This is a placeholder for real implementation
            
            return response()->json(['error' => 'PayPal processing not implemented for production'], 500);
            
        } catch (\Exception $e) {
            Log::error('PayPal payment error: ' . $e->getMessage());
            return response()->json(['error' => 'Payment processing failed'], 500);
        }
    }
    
    public function webhook(Request $request)
    {
        // Handle payment webhooks from Stripe/PayPal
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature') ?? $request->header('PayPal-Signature');
        
        try {
            // Verify webhook signature and process payment updates
            Log::info('Payment webhook received', ['payload' => $payload]);
            
            // Process the webhook based on payment provider
            // Update appointment status accordingly
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Webhook processing error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }
}
