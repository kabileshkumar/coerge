@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    <div class="form-header">
        <h1><i class="fas fa-key"></i> Reset Password</h1>
        <p class="subtitle">Enter your email to receive a reset link</p>
    </div>

    <div class="form-body">
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
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

        <form method="POST" action="{{ route('auth.forgot-password') }}" id="forgotPasswordForm">
            @csrf
            
            <div class="section-header">
                <h5><i class="fas fa-envelope"></i> Email Address</h5>
                <p>We'll send you a link to reset your password</p>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Email Address
                </label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="your.email@example.com"
                       required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane"></i> Send Reset Link
                </button>
            </div>

            <div class="form-footer">
                <div class="text-center">
                    <a href="{{ route('auth.signin') }}" class="text-link">
                        <i class="fas fa-arrow-left"></i> Back to Sign In
                    </a>
                </div>
                
                <div class="divider">
                    <span>or</span>
                </div>
                
                <div class="text-center">
                    <p class="mb-0">Don't have an account?</p>
                    <a href="{{ route('appointment.registration') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user-plus"></i> Create New Account
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Form validation
    $(document).ready(function() {
        $('#forgotPasswordForm').on('submit', function() {
            clearAllErrors();
            
            let isValid = true;
            
            // Email validation
            const email = $('#email').val().trim();
            if (!email) {
                showFieldError('email', 'Email address is required');
                isValid = false;
            } else if (!isValidEmail(email)) {
                showFieldError('email', 'Please enter a valid email address');
                isValid = false;
            }
            
            return isValid;
        });
        
        // Real-time validation
        $('#email').on('blur', function() {
            const email = $(this).val().trim();
            clearFieldError('email');
            
            if (email && !isValidEmail(email)) {
                showFieldError('email', 'Please enter a valid email address');
            }
        });
    });
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
</script>
@endpush

