@extends('layouts.app')

@section('title', 'PayPal Payment - Book Your Appointment')

@section('content')
<div class="form-header">
    <h1>Complete Payment</h1>
</div>

<div class="form-body">
    <div class="payment-header text-center mb-4">
        <i class="fab fa-paypal fa-3x text-primary mb-3"></i>
        <h4>PayPal Payment</h4>
        <p class="text-muted">Amount: <strong>${{ number_format($appointment->appointment_fee, 2) }}</strong></p>
    </div>

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Test Mode:</strong> This is a test environment. Payment will be simulated for demonstration purposes.
    </div>

    <div class="paypal-container">
        <div id="paypal-button-container"></div>
        
        <!-- Fallback button for test mode -->
        <button id="test-paypal-btn" class="btn btn-primary btn-lg w-100 mt-3">
            <i class="fab fa-paypal me-2"></i>Pay with PayPal (Test Mode)
        </button>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('appointment.payment') }}" class="text-muted">
            <i class="fas fa-arrow-left me-2"></i>Back to payment options
        </a>
    </div>

    <div class="security-info mt-4">
        <div class="row text-center text-muted">
            <div class="col-4">
                <i class="fas fa-shield-alt fa-2x mb-2"></i>
                <div class="small">Secure</div>
            </div>
            <div class="col-4">
                <i class="fas fa-lock fa-2x mb-2"></i>
                <div class="small">Encrypted</div>
            </div>
            <div class="col-4">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <div class="small">Verified</div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.paypal-container {
    max-width: 400px;
    margin: 0 auto;
}

.payment-header {
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 20px;
    margin-bottom: 30px;
}

.security-info {
    border-top: 1px solid var(--border-color);
    padding-top: 20px;
}

#paypal-button-container {
    margin-bottom: 20px;
}

.btn-paypal {
    background-color: #0070ba;
    border-color: #0070ba;
    color: white;
}

.btn-paypal:hover {
    background-color: #005ea6;
    border-color: #005ea6;
}
</style>
@endpush

@push('scripts')
<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
<script>
$(document).ready(function() {
    // For test mode, use the fallback button
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        $('#test-paypal-btn').show();
        $('#paypal-button-container').hide();
        
        $('#test-paypal-btn').click(function() {
            $(this).prop('disabled', true);
            $(this).html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...');
            
            // Simulate PayPal payment processing
            setTimeout(function() {
                $.post('{{ route("payment.paypal.process") }}', {
                    _token: '{{ csrf_token() }}',
                    test_mode: true
                })
                .done(function(response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert('Payment failed: ' + response.error);
                        $('#test-paypal-btn').prop('disabled', false);
                        $('#test-paypal-btn').html('<i class="fab fa-paypal me-2"></i>Pay with PayPal (Test Mode)');
                    }
                })
                .fail(function() {
                    alert('Payment processing failed. Please try again.');
                    $('#test-paypal-btn').prop('disabled', false);
                    $('#test-paypal-btn').html('<i class="fab fa-paypal me-2"></i>Pay with PayPal (Test Mode)');
                });
            }, 2000);
        });
    } else {
        // Real PayPal integration
        $('#test-paypal-btn').hide();
        
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{ number_format($appointment->appointment_fee, 2, ".", "") }}'
                        },
                        description: 'Medical Appointment - {{ $appointment->appointment_type }}'
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Send payment details to server
                    $.post('{{ route("payment.paypal.process") }}', {
                        _token: '{{ csrf_token() }}',
                        order_id: data.orderID,
                        payer_id: data.payerID,
                        payment_details: details
                    })
                    .done(function(response) {
                        if (response.success) {
                            window.location.href = response.redirect_url;
                        } else {
                            alert('Payment verification failed: ' + response.error);
                        }
                    })
                    .fail(function() {
                        alert('Payment verification failed. Please contact support.');
                    });
                });
            },
            onError: function(err) {
                console.error('PayPal Error:', err);
                alert('Payment failed. Please try again or use a different payment method.');
            },
            onCancel: function(data) {
                console.log('PayPal payment cancelled:', data);
                // User cancelled payment - no action needed
            }
        }).render('#paypal-button-container');
    }
});
</script>
@endpush
@endsection
