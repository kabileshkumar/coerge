@extends('layouts/app')

@section('title', 'Appointment Confirmed!')

@section('content')
    <div class="form-header">
        <h1><i class="fas fa-check-circle success-icon"></i> Appointment Confirmed!</h1>
        <p class="subtitle">Your appointment has been successfully booked</p>
    </div>

    <div class="form-body">
        <div class="confirmation-card">
            <h5 class="card-title">
                <i class="fas fa-calendar-check"></i> Appointment Details
            </h5>
            
            <div class="detail-row">
                <span class="detail-label">Patient Name:</span>
                <span class="detail-value">{{ $appointment->full_name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Appointment Type:</span>
                <span class="detail-value">{{ ucfirst(str_replace('_', ' ', $appointment->appointment_type)) }}</span>
            </div>
            
            @if($appointment->preferred_date)
            <div class="detail-row">
                <span class="detail-label">Appointment Date:</span>
                <span class="detail-value">{{ $appointment->preferred_date->format('F j, Y') }}</span>
            </div>
            @endif
            
            @if($appointment->preferred_time)
            <div class="detail-row">
                <span class="detail-label">Preferred Time:</span>
                <span class="detail-value">{{ ucfirst($appointment->preferred_time) }}</span>
            </div>
            @endif
            
            @if($appointment->preferred_doctor)
            <div class="detail-row">
                <span class="detail-label">Doctor:</span>
                <span class="detail-value">{{ $appointment->preferred_doctor }}</span>
            </div>
            @endif
            
            <div class="detail-row">
                <span class="detail-label">Appointment Fee:</span>
                <span class="detail-value">{{ $appointment->formatted_appointment_fee }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Payment Status:</span>
                <span class="detail-value">
                    <span class="badge bg-success">{{ ucfirst($appointment->payment_status) }}</span>
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Appointment ID:</span>
                <span class="detail-value">#{{ $appointment->id }}</span>
            </div>
        </div>

        <div class="next-steps">
            <h5 class="card-title">
                <i class="fas fa-list-check"></i> What Happens Next?
            </h5>
            
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-content">
                    <strong>Confirmation Email</strong>
                    <p>You'll receive a confirmation email with all the details and any pre-appointment instructions.</p>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-content">
                    <strong>Reminder Notifications</strong>
                    <p>We'll send you SMS and email reminders 24 hours before your appointment.</p>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-content">
                    <strong>Check-in Process</strong>
                    <p>Please arrive 15 minutes early and bring a valid ID and insurance card if applicable.</p>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-content">
                    <strong>Virtual Waiting Room</strong>
                    <p>You can join our virtual waiting room 10 minutes before your scheduled time.</p>
                </div>
            </div>
        </div>

        <div class="contact-info">
            <h5 class="card-title">
                <i class="fas fa-phone"></i> Need to Make Changes?
            </h5>
            
            <div class="contact-methods">
                <div><i class="fas fa-phone"></i> Call us: <strong>+1 (555) 123-4567</strong></div>
                <div><i class="fas fa-envelope"></i> Email: <strong>appointments@coerge.com</strong></div>
                <div><i class="fas fa-clock"></i> Hours: <strong>Monday-Friday 8:00 AM - 6:00 PM</strong></div>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                <strong>Rescheduling:</strong> You can reschedule or cancel your appointment up to 24 hours before the scheduled time without any fees.
            </div>
        </div>

        <div class="d-flex gap-3 mt-4">
            <a href="{{ route('appointment.registration') }}" class="btn btn-outline flex-fill">
                <i class="fas fa-plus"></i>
                Book Another Appointment
            </a>
            <a href="#" class="btn btn-primary flex-fill">
                <i class="fas fa-download"></i>
                Download Confirmation
            </a>
        </div>

        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="fas fa-heart"></i>
                Thank you for choosing Coerge Medical. We look forward to seeing you!
            </small>
        </div>
    </div>

    <script>
        // Add some interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Animate the success icon
            const successIcon = document.querySelector('.success-icon');
            if (successIcon) {
                successIcon.style.animation = 'successBounce 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
            }
            
            // Add hover effects to contact methods
            const contactMethods = document.querySelectorAll('.contact-methods div');
            contactMethods.forEach(function(method) {
                method.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(10px)';
                    this.style.transition = 'transform 0.3s ease';
                });
                
                method.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>
@endsection
