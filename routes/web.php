<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;

// Redirect root to appointment registration
Route::get('/', function () {
    return redirect()->route('appointment.registration');
});

// Appointment booking routes
Route::prefix('appointment')->name('appointment.')->group(function () {
    // Step 1: Registration
    Route::get('/registration', [AppointmentController::class, 'showRegistration'])->name('registration');
    Route::post('/registration', [AppointmentController::class, 'storeRegistration'])->name('registration.store');
    
    // Step 2: Booking Details
    Route::get('/booking-details', [AppointmentController::class, 'showBookingDetails'])->name('booking-details');
    Route::post('/booking-details', [AppointmentController::class, 'storeBookingDetails'])->name('booking-details.store');
    
    // Step 3: Payment
    Route::get('/payment', [AppointmentController::class, 'showPayment'])->name('payment');
    Route::post('/payment', [AppointmentController::class, 'processPayment'])->name('payment.process');
    
    // Success page
    Route::get('/success', [AppointmentController::class, 'success'])->name('success');
});

// Payment processing routes
Route::prefix('payment')->name('payment.')->group(function () {
    // Stripe payment routes
    Route::get('/stripe', [PaymentController::class, 'processStripe'])->name('stripe');
    Route::post('/stripe/process', [PaymentController::class, 'handleStripePayment'])->name('stripe.process');
    
    // PayPal payment routes
    Route::get('/paypal', [PaymentController::class, 'processPayPal'])->name('paypal');
    Route::post('/paypal/process', [PaymentController::class, 'handlePayPalPayment'])->name('paypal.process');
    
    // Webhook for payment notifications
    Route::post('/webhook', [PaymentController::class, 'webhook'])->name('webhook');
});

// Authentication routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/signin', [AuthController::class, 'showSignIn'])->name('signin');
    Route::post('/signin', [AuthController::class, 'signIn'])->name('signin');
    Route::post('/signout', [AuthController::class, 'signOut'])->name('signout');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
});
