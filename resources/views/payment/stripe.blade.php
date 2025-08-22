@extends('layouts.app')

@section('title', 'Stripe Payment - Book Your Appointment')

@section('content')
<div class="form-header">
    <h1>Complete Payment</h1>
</div>

<div class="form-body">
    <div class="payment-header text-center mb-4">
        <i class="fas fa-credit-card fa-3x text-primary mb-3"></i>
        <h4>Secure Card Payment</h4>
        <p class="text-muted">Amount: <strong>${{ number_format($appointment->appointment_fee, 2) }}</strong></p>
    </div>

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Test Mode:</strong> This is a test environment. Use test card number 4242424242424242 with any future expiry date and any 3-digit CVC.
    </div>

    <form id="payment-form" class="stripe-form">
        @csrf
        <div class="form-group">
            <label for="cardholder-name" class="form-label">Cardholder Name</label>
            <input type="text" id="cardholder-name" class="form-control" placeholder="Name on card" required>
        </div>

        <div class="form-group">
            <label for="card-element" class="form-label">Card Information</label>
            <div id="card-element" class="form-control" style="padding: 12px;">
                <!-- Stripe Elements will create form elements here -->
            </div>
            <div id="card-errors" role="alert" class="invalid-feedback"></div>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="save-card" name="save_card">
                <label class="form-check-label" for="save-card">
                    Save this card for future appointments
                </label>
            </div>
        </div>

        <button id="submit-payment" class="btn btn-primary btn-lg w-100">
            <i class="fas fa-lock me-2"></i>Pay ${{ number_format($appointment->appointment_fee, 2) }}
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('appointment.payment') }}" class="text-muted">
            <i class="fas fa-arrow-left me-2"></i>Back to payment options
        </a>
    </div>
</div>

@push('styles')
<style>
.stripe-form {
    max-width: 400px;
    margin: 0 auto;
}

#card-element {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    padding: 12px;
    margin: 10px 0;
}

#card-element.StripeElement--focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.1);
}

#card-element.StripeElement--invalid {
    border-color: var(--danger-color);
}

.payment-header {
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 20px;
    margin-bottom: 30px;
}

.security-badges {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
    opacity: 0.7;
}

.security-badges i {
    font-size: 24px;
    color: var(--secondary-color);
}
</style>
@endpush

@push('scripts')
<!-- Include Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
<script>
$(document).ready(function() {
    // Initialize Stripe (use test key in development)
    const stripe = Stripe('pk_test_51234567890abcdef'); // Replace with your actual test publishable key
    const elements = stripe.elements();

    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '14px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
                fontFamily: 'Inter, sans-serif',
            },
            invalid: {
                color: '#9e2146',
            },
        },
    });

    cardElement.mount('#card-element');

    // Handle real-time validation errors from the card Element
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
            displayError.style.display = 'block';
        } else {
            displayError.textContent = '';
            displayError.style.display = 'none';
        }
    });

    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        const submitButton = document.getElementById('submit-payment');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';

        // For test mode, simulate successful payment
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            setTimeout(function() {
                // Simulate successful payment in test mode
                $.post('{{ route("payment.stripe.process") }}', {
                    _token: '{{ csrf_token() }}',
                    test_mode: true
                })
                .done(function(response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert('Payment failed: ' + response.error);
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay ${{ number_format($appointment->appointment_fee, 2) }}';
                    }
                })
                .fail(function() {
                    alert('Payment processing failed. Please try again.');
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay ${{ number_format($appointment->appointment_fee, 2) }}';
                });
            }, 2000); // Simulate 2 second processing time
            return;
        }

        // Real Stripe payment processing would go here
        const {token, error} = await stripe.createToken(cardElement);

        if (error) {
            // Show error to customer
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            errorElement.style.display = 'block';
            
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay ${{ number_format($appointment->appointment_fee, 2) }}';
        } else {
            // Send token to server
            const formData = new FormData(form);
            formData.append('stripe_token', token.id);
            
            fetch('{{ route("payment.stripe.process") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    alert('Payment failed: ' + data.error);
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay ${{ number_format($appointment->appointment_fee, 2) }}';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Payment processing failed. Please try again.');
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay ${{ number_format($appointment->appointment_fee, 2) }}';
            });
        }
    });
});
</script>
@endpush
@endsection
