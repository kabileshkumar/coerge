@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
    <div class="form-header">
        <h1><i class="fas fa-sign-in-alt"></i> Welcome Back</h1>
        <p class="subtitle">Sign in to your account to continue</p>
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

        <form method="POST" action="{{ route('auth.signin') }}" id="signinForm">
            @csrf
            
            <div class="section-header">
                <h5><i class="fas fa-user"></i> Sign In</h5>
                <p>Enter your credentials to access your account</p>
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

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Password
                </label>
                <div class="password-input-group">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Enter your password"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </div>

            <div class="form-footer">
                <div class="text-center">
                    <a href="{{ route('auth.forgot-password') }}" class="text-link">
                        <i class="fas fa-key"></i> Forgot your password?
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
    // Password toggle functionality
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const toggle = field.nextElementSibling.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            toggle.classList.remove('fa-eye');
            toggle.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            toggle.classList.remove('fa-eye-slash');
            toggle.classList.add('fa-eye');
        }
    }
    
    // Form validation
    $(document).ready(function() {
        $('#signinForm').on('submit', function() {
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
            
            // Password validation
            const password = $('#password').val();
            if (!password) {
                showFieldError('password', 'Password is required');
                isValid = false;
            } else if (password.length < 8) {
                showFieldError('password', 'Password must be at least 8 characters');
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
        
        $('#password').on('blur', function() {
            const password = $(this).val();
            clearFieldError('password');
            
            if (password && password.length < 8) {
                showFieldError('password', 'Password must be at least 8 characters');
            }
        });
    });
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
</script>
@endpush
