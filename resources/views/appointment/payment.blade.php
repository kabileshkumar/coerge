@extends('layouts.app')

@section('title', 'Step 3: Payment & Confirmation')

@section('content')
    <div class="form-header">
        <h1><i class="fas fa-credit-card"></i> Payment</h1>
        <p class="subtitle">Complete your appointment booking</p>
    </div>

    <div class="progress-container">
        <div class="progress-steps">
            <div class="progress-line" style="width: 100%"></div>
            <div class="step completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-label">Personal Info</div>
            </div>
            <div class="step completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-label">Medical Details</div>
            </div>
            <div class="step active">
                <div class="step-circle">3</div>
                <div class="step-label">Payment</div>
            </div>
        </div>
    </div>

    <div class="form-body">
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                Please correct the following errors:
                <ul class="mt-2 mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="payment-summary">
            <div class="section-header">
                <h5><i class="fas fa-receipt"></i> Appointment Summary</h5>
                <p>Review your appointment details before payment</p>
            </div>
            
            <div class="summary-card">
                <div class="summary-row">
                    <span class="summary-label">Appointment Type:</span>
                    <span class="summary-value">{{ session('booking_data.appointment_type', 'consultation') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Date:</span>
                    <span class="summary-value">{{ session('booking_data.preferred_date') ? date('F j, Y', strtotime(session('booking_data.preferred_date'))) : 'Not specified' }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Time:</span>
                    <span class="summary-value">{{ ucfirst(session('booking_data.preferred_time', 'Not specified')) }}</span>
                </div>
                @if(session('booking_data.preferred_doctor'))
                <div class="summary-row">
                    <span class="summary-label">Doctor:</span>
                    <span class="summary-value">{{ session('booking_data.preferred_doctor') }}</span>
                </div>
                @endif
                <div class="summary-row total-row">
                    <span class="summary-label">Total Fee:</span>
                    <span class="summary-value">${{ number_format($fee, 2) }}</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('appointment.payment.process') }}" id="paymentForm">
            @csrf
            
            <div class="section-header">
                <h5><i class="fas fa-credit-card"></i> Payment Method</h5>
                <p>Choose your preferred payment option</p>
            </div>

            <div class="payment-methods">
                <div class="payment-method">
                    <input type="radio" 
                           class="payment-radio" 
                           id="stripe" 
                           name="payment_method" 
                           value="stripe" 
                           {{ old('payment_method') == 'stripe' ? 'checked' : '' }}
                           required>
                    <label for="stripe" class="payment-label">
                        <div class="payment-icon">
                            <i class="fab fa-stripe"></i>
                        </div>
                        <div class="payment-info">
                            <div class="payment-title">Credit/Debit Card</div>
                            <div class="payment-desc">Secure payment via Stripe</div>
                            <div class="payment-cards">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-amex"></i>
                                <i class="fab fa-cc-discover"></i>
                            </div>
                        </div>
                        <div class="payment-check">
                            <i class="fas fa-check"></i>
                        </div>
                    </label>
                </div>

                <div class="payment-method">
                    <input type="radio" 
                           class="payment-radio" 
                           id="paypal" 
                           name="payment_method" 
                           value="paypal" 
                           {{ old('payment_method') == 'paypal' ? 'checked' : '' }}
                           required>
                    <label for="paypal" class="payment-label">
                        <div class="payment-icon">
                            <i class="fab fa-paypal"></i>
                        </div>
                        <div class="payment-info">
                            <div class="payment-title">PayPal</div>
                            <div class="payment-desc">Pay with your PayPal account</div>
                            <div class="payment-cards">
                                <i class="fab fa-paypal"></i>
                            </div>
                        </div>
                        <div class="payment-check">
                            <i class="fas fa-check"></i>
                        </div>
                    </label>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-shield-alt"></i>
                <strong>Secure Payment:</strong> All payments are encrypted and processed securely. We never store your payment information.
            </div>

            <div class="d-flex gap-3">
                <a href="{{ route('appointment.booking-details') }}" class="btn btn-outline flex-fill">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="fas fa-lock"></i>
                    Pay ${{ number_format($fee, 2) }} & Book Appointment
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="fas fa-info-circle"></i>
                By proceeding, you agree to our <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
            </small>
        </div>
    </div>

    <script>
        // Update progress line
        document.addEventListener('DOMContentLoaded', function() {
            updateProgressLine(3);
        });

        // Payment method selection
        document.querySelectorAll('.payment-radio').forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Remove active class from all labels
                document.querySelectorAll('.payment-label').forEach(function(label) {
                    label.classList.remove('active');
                });
                
                // Add active class to selected label
                if (this.checked) {
                    this.nextElementSibling.classList.add('active');
                }
            });
        });

        // Form validation
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
            
            if (!selectedPayment) {
                e.preventDefault();
                alert('Please select a payment method to continue.');
                return false;
            }
        });

        // Auto-select first payment method if none selected
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('.payment-radio');
            if (paymentMethods.length > 0 && !document.querySelector('.payment-radio:checked')) {
                paymentMethods[0].checked = true;
                paymentMethods[0].nextElementSibling.classList.add('active');
            }
        });
    </script>
@endsection
