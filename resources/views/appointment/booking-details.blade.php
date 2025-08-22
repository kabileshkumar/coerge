@extends('layouts.app')

@section('title', 'Step 2: Medical & Appointment Details')

@section('content')
    <div class="form-header">
        <h1><i class="fas fa-stethoscope"></i> Medical Details</h1>
        <p class="subtitle">Help us understand your health needs</p>
    </div>

    <div class="progress-container">
        <div class="progress-steps">
            <div class="progress-line" style="width: 50%"></div>
            <div class="step completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-label">Personal Info</div>
            </div>
            <div class="step active">
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

        <form method="POST" action="{{ route('appointment.booking-details.store') }}" id="bookingForm">
            @csrf
            
            <div class="section-header">
                <h5><i class="fas fa-calendar-alt"></i> Appointment Preferences</h5>
                <p>Choose your preferred appointment details</p>
            </div>

            <div class="form-group">
                <label for="appointment_type" class="form-label">
                    <i class="fas fa-list"></i> Appointment Type
                </label>
                <select class="form-control @error('appointment_type') is-invalid @enderror" 
                        id="appointment_type" 
                        name="appointment_type" 
                        required>
                    <option value="">Select appointment type</option>
                    <option value="consultation" {{ old('appointment_type') == 'consultation' ? 'selected' : '' }}>
                        General Consultation ($75)
                    </option>
                    <option value="follow_up" {{ old('appointment_type') == 'follow_up' ? 'selected' : '' }}>
                        Follow-up Visit ($50)
                    </option>
                    <option value="specialist" {{ old('appointment_type') == 'specialist' ? 'selected' : '' }}>
                        Specialist Consultation ($150)
                    </option>
                    <option value="emergency" {{ old('appointment_type') == 'emergency' ? 'selected' : '' }}>
                        Emergency Visit ($200)
                    </option>
                </select>
                @error('appointment_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="preferred_date" class="form-label">
                    <i class="fas fa-calendar"></i> Preferred Date
                </label>
                <input type="date" 
                       class="form-control @error('preferred_date') is-invalid @enderror" 
                       id="preferred_date" 
                       name="preferred_date" 
                       value="{{ old('preferred_date') }}" 
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       required>
                @error('preferred_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="preferred_time" class="form-label">
                    <i class="fas fa-clock"></i> Preferred Time
                </label>
                <select class="form-control @error('preferred_time') is-invalid @enderror" 
                        id="preferred_time" 
                        name="preferred_time" 
                        required>
                    <option value="">Select preferred time</option>
                    <option value="morning" {{ old('preferred_time') == 'morning' ? 'selected' : '' }}>
                        Morning (9:00 AM - 12:00 PM)
                    </option>
                    <option value="afternoon" {{ old('preferred_time') == 'afternoon' ? 'selected' : '' }}>
                        Afternoon (1:00 PM - 4:00 PM)
                    </option>
                    <option value="evening" {{ old('preferred_time') == 'evening' ? 'selected' : '' }}>
                        Evening (4:00 PM - 7:00 PM)
                    </option>
                </select>
                @error('preferred_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="preferred_doctor" class="form-label">
                    <i class="fas fa-user-md"></i> Preferred Doctor (Optional)
                </label>
                <select class="form-control @error('preferred_doctor') is-invalid @enderror" 
                        id="preferred_doctor" 
                        name="preferred_doctor">
                    <option value="">Any available doctor</option>
                    <option value="dr_smith" {{ old('preferred_doctor') == 'dr_smith' ? 'selected' : '' }}>
                        Dr. Sarah Smith - General Medicine
                    </option>
                    <option value="dr_johnson" {{ old('preferred_doctor') == 'dr_johnson' ? 'selected' : '' }}>
                        Dr. Michael Johnson - Cardiology
                    </option>
                    <option value="dr_williams" {{ old('preferred_doctor') == 'dr_williams' ? 'selected' : '' }}>
                        Dr. Emily Williams - Pediatrics
                    </option>
                    <option value="dr_brown" {{ old('preferred_doctor') == 'dr_brown' ? 'selected' : '' }}>
                        Dr. David Brown - Orthopedics
                    </option>
                </select>
                @error('preferred_doctor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="section-header">
                <h5><i class="fas fa-heartbeat"></i> Health Information</h5>
                <p>Help us provide better care</p>
            </div>

            <div class="form-group">
                <label for="symptoms" class="form-label">
                    <i class="fas fa-thermometer-half"></i> Symptoms
                </label>
                <textarea class="form-control @error('symptoms') is-invalid @enderror" 
                          id="symptoms" 
                          name="symptoms" 
                          rows="3" 
                          placeholder="Describe your symptoms or reason for visit">{{ old('symptoms') }}</textarea>
                @error('symptoms')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="medical_history" class="form-label">
                    <i class="fas fa-history"></i> Medical History
                </label>
                <textarea class="form-control @error('medical_history') is-invalid @enderror" 
                          id="medical_history" 
                          name="medical_history" 
                          rows="3" 
                          placeholder="Any relevant medical history, surgeries, or chronic conditions">{{ old('medical_history') }}</textarea>
                @error('medical_history')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="current_medications" class="form-label">
                    <i class="fas fa-pills"></i> Current Medications
                </label>
                <textarea class="form-control @error('current_medications') is-invalid @enderror" 
                          id="current_medications" 
                          name="current_medications" 
                          rows="3" 
                          placeholder="List any medications you are currently taking">{{ old('current_medications') }}</textarea>
                @error('current_medications')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="additional_notes" class="form-label">
                    <i class="fas fa-edit"></i> Additional Notes
                </label>
                <textarea class="form-control @error('additional_notes') is-invalid @enderror" 
                          id="additional_notes" 
                          name="additional_notes" 
                          rows="3" 
                          placeholder="Any other information you'd like us to know">{{ old('additional_notes') }}</textarea>
                @error('additional_notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-3">
                <a href="{{ route('appointment.registration') }}" class="btn btn-outline flex-fill">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="fas fa-arrow-right"></i>
                    Continue to Payment
                </button>
            </div>
        </form>
    </div>

    <script>
        // Update progress line
        document.addEventListener('DOMContentLoaded', function() {
            updateProgressLine(2);
        });

        // Form validation
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Check if appointment type is selected
            const appointmentType = document.getElementById('appointment_type').value;
            if (!appointmentType) {
                showFieldError('appointment_type', 'Please select an appointment type');
                isValid = false;
            }
            
            // Check if date is selected
            const preferredDate = document.getElementById('preferred_date').value;
            if (!preferredDate) {
                showFieldError('preferred_date', 'Please select a preferred date');
                isValid = false;
            }
            
            // Check if time is selected
            const preferredTime = document.getElementById('preferred_time').value;
            if (!preferredTime) {
                showFieldError('preferred_time', 'Please select a preferred time');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });

        // Real-time validation
        document.getElementById('appointment_type').addEventListener('change', function() {
            if (this.value) {
                clearFieldError('appointment_type');
            }
        });
        
        document.getElementById('preferred_date').addEventListener('change', function() {
            if (this.value) {
                clearFieldError('preferred_date');
            }
        });
        
        document.getElementById('preferred_time').addEventListener('change', function() {
            if (this.value) {
                clearFieldError('preferred_time');
            }
        });
    </script>
@endsection
