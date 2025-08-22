@extends('layouts.app')

@section('title', 'Step 1: Personal Information')

@section('content')
    <div class="form-header">
        <h1><i class="fas fa-user-plus"></i> Create Account</h1>
        <p class="subtitle">Start your journey to better health</p>
    </div>

    <div class="progress-container">
        <div class="progress-steps">
            <div class="progress-line" style="width: 0%"></div>
            <div class="step active">
                <div class="step-circle">1</div>
                <div class="step-label">Personal Info</div>
            </div>
            <div class="step">
                <div class="step-circle">2</div>
                <div class="step-label">Medical Details</div>
            </div>
            <div class="step">
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

        <form method="POST" action="{{ route('appointment.registration.store') }}" id="registrationForm">
            @csrf
            
            <div class="section-header">
                <h5><i class="fas fa-user"></i> Personal Information</h5>
                <p>Tell us about yourself to get started</p>
            </div>

            <div class="form-group">
                <label for="full_name" class="form-label">
                    <i class="fas fa-user"></i> Full Name
                </label>
                <input type="text" 
                       class="form-control @error('full_name') is-invalid @enderror" 
                       id="full_name" 
                       name="full_name" 
                       value="{{ old('full_name') }}" 
                       placeholder="Enter your full name"
                       required>
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
                <label class="form-label">
                    <i class="fas fa-phone"></i> Phone Number
                </label>
                <div class="input-group">
                    <select class="form-control phone-code @error('phone_code') is-invalid @enderror" 
                            name="phone_code" 
                            required>
                        <option value="">Code</option>
                        <option value="+1" {{ old('phone_code') == '+1' ? 'selected' : '' }}>+1 (US/CA)</option>
                        <option value="+44" {{ old('phone_code') == '+44' ? 'selected' : '' }}>+44 (UK)</option>
                        <option value="+91" {{ old('phone_code') == '+91' ? 'selected' : '' }}>+91 (IN)</option>
                        <option value="+61" {{ old('phone_code') == '+61' ? 'selected' : '' }}>+61 (AU)</option>
                        <option value="+49" {{ old('phone_code') == '+49' ? 'selected' : '' }}>+49 (DE)</option>
                        <option value="+33" {{ old('phone_code') == '+33' ? 'selected' : '' }}>+33 (FR)</option>
                        <option value="+81" {{ old('phone_code') == '+81' ? 'selected' : '' }}>+81 (JP)</option>
                        <option value="+86" {{ old('phone_code') == '+86' ? 'selected' : '' }}>+86 (CN)</option>
                        <option value="+55" {{ old('phone_code') == '+55' ? 'selected' : '' }}>+55 (BR)</option>
                        <option value="+7" {{ old('phone_code') == '+7' ? 'selected' : '' }}>+7 (RU)</option>
                    </select>
                    <input type="tel" 
                           class="form-control mobile-input @error('mobile_number') is-invalid @enderror" 
                           name="mobile_number" 
                           value="{{ old('mobile_number') }}" 
                           placeholder="Enter mobile number"
                           required>
                </div>
                @error('phone_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('mobile_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Password
                </label>
                <div class="position-relative">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Create a strong password"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Password must be at least 8 characters long
                </small>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">
                    <i class="fas fa-lock"></i> Confirm Password
                </label>
                <div class="position-relative">
                    <input type="password" 
                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Confirm your password"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-shield-alt"></i> Terms & Conditions
                </label>
                <div class="form-check">
                    <input class="form-check-input @error('terms_conditions') is-invalid @enderror" 
                           type="checkbox" 
                           id="privacy" 
                           name="terms_conditions[privacy]" 
                           value="1" 
                           {{ old('terms_conditions.privacy') ? 'checked' : '' }}
                           required>
                    <label class="form-check-label" for="privacy">
                        I agree to the <a href="#" class="text-primary">Privacy Policy</a> and data processing terms
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input @error('terms_conditions') is-invalid @enderror" 
                           type="checkbox" 
                           id="marketing" 
                           name="terms_conditions[marketing]" 
                           value="1" 
                           {{ old('terms_conditions.marketing') ? 'checked' : '' }}
                           required>
                    <label class="form-check-label" for="marketing">
                        I agree to receive appointment reminders and health updates via email/SMS
                    </label>
                </div>
                @error('terms_conditions')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-arrow-right"></i>
                    Continue to Medical Details
                </button>
            </div>

            <div class="divider">
                <span>or</span>
            </div>

            <a href="#" class="google-signin">
                <i class="fab fa-google"></i>
                <span>Continue with Google</span>
            </a>

            <div class="text-center">
                <small class="text-muted">
                    Already have an account? 
                    <a href="{{ route('auth.signin') }}" class="text-primary">Sign in here</a>
                </small>
            </div>
        </form>
    </div>

    <script>
        // Password toggle functionality
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const toggle = field.nextElementSibling;
            const icon = toggle.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            clearAllErrors();
            
            let isValid = true;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                showFieldError('password_confirmation', 'Passwords do not match');
                isValid = false;
            }
            
            if (password.length < 8) {
                showFieldError('password', 'Password must be at least 8 characters long');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });

        // Real-time validation
        document.querySelectorAll('.form-control').forEach(function(field) {
            field.addEventListener('blur', function() {
                const fieldName = this.name;
                const value = this.value;
                
                if (fieldName === 'email' && value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        showFieldError(fieldName, 'Please enter a valid email address');
                    } else {
                        clearFieldError(fieldName);
                    }
                }
                
                if (fieldName === 'mobile_number' && value) {
                    const phoneRegex = /^\d{10,15}$/;
                    if (!phoneRegex.test(value)) {
                        showFieldError(fieldName, 'Please enter a valid phone number');
                    } else {
                        clearFieldError(fieldName);
                    }
                }
            });
        });
    </script>
@endsection
