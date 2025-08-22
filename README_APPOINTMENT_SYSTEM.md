# Coerge Form - Appointment Booking System

This Laravel application provides a complete appointment booking system with multi-step registration, MySQL database integration, and test payment processing.

## Features

### ✅ Completed Features
- **Multi-step Registration Form** with 3 steps:
  1. Personal Information & Registration
  2. Appointment Details & Medical Information
  3. Payment & Confirmation

- **Database Integration**
  - MySQL database configuration
  - Appointments table with comprehensive fields
  - Eloquent model with relationships and scopes

- **Payment Integration (Test Mode)**
  - Stripe payment integration (test mode)
  - PayPal payment integration (test mode)
  - Secure payment processing simulation

- **Modern UI/UX**
  - Bootstrap 5 responsive design
  - Progress indicator for multi-step form
  - Form validation with real-time feedback
  - Modern card-based layout similar to your design

## Database Schema

The `appointments` table includes:
- Personal information (name, email, phone)
- Appointment details (type, date, time, doctor preference)
- Medical information (symptoms, history, medications)
- Payment information (amount, status, transaction ID)
- Status tracking and metadata

## Installation & Setup

1. **Database Configuration**
   - Create a MySQL database named `coerge_form`
   - Update `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=coerge_form
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

2. **Run Migrations**
   ```bash
   php artisan migrate
   ```

3. **Start Development Server**
   ```bash
   php artisan serve
   ```

4. **Access the Application**
   - Open your browser and go to `http://localhost:8000`
   - You'll be redirected to the registration form

## Application Flow

### Step 1: Registration
- Personal information collection
- Email and password setup
- Phone number with country code
- Terms and conditions acceptance
- Google Sign-in option (placeholder)

### Step 2: Booking Details
- Appointment type selection with pricing
- Symptoms and reason for visit
- Doctor and time preferences
- Medical history and current medications
- Additional notes

### Step 3: Payment & Confirmation
- Payment summary display
- Payment method selection (Stripe/PayPal)
- Secure payment processing (test mode)
- Confirmation page with appointment details

## Payment Testing

### Test Mode Features
- **Stripe Test Mode**: Simulates successful payment processing
- **PayPal Test Mode**: Simulates PayPal payment flow
- **Test Cards**: Use 4242424242424242 for Stripe testing
- **Database Storage**: All appointments are saved with payment status

### Test Payment Flow
1. Complete registration and booking details
2. Select payment method (Stripe or PayPal)
3. Process test payment (automatically successful in local environment)
4. View confirmation page with appointment details

## File Structure

```
app/
├── Http/Controllers/
│   ├── AppointmentController.php  # Handles multi-step form
│   └── PaymentController.php      # Handles payment processing
├── Models/
│   └── Appointment.php            # Eloquent model
database/
├── migrations/
│   └── create_appointments_table.php
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php          # Base layout
│   ├── appointment/
│   │   ├── registration.blade.php # Step 1
│   │   ├── booking-details.blade.php # Step 2
│   │   ├── payment.blade.php      # Step 3
│   │   └── success.blade.php      # Confirmation
│   └── payment/
│       ├── stripe.blade.php       # Stripe payment
│       └── paypal.blade.php       # PayPal payment
routes/
└── web.php                        # Application routes
```

## Key Features Implemented

### Form Validation
- Client-side and server-side validation
- Real-time password confirmation
- Required field validation
- Email format validation
- Phone number validation

### Session Management
- Multi-step form data stored in sessions
- Secure session handling
- Data persistence across steps
- Session cleanup after completion

### Security Features
- CSRF protection
- Password hashing
- Input sanitization
- Secure payment processing
- Data validation and filtering

### User Experience
- Progress indicator
- Smooth transitions between steps
- Error handling and feedback
- Mobile-responsive design
- Loading states and animations

## Testing the Application

1. **Complete Registration**
   - Fill out personal information
   - Create account credentials
   - Accept terms and conditions

2. **Add Booking Details**
   - Select appointment type
   - Choose preferred date/time
   - Add medical information

3. **Process Payment**
   - Review payment summary
   - Select payment method
   - Complete test payment

4. **View Confirmation**
   - See appointment confirmation
   - Print or email details
   - Check database for stored record

## Next Steps for Production

1. **Real Payment Integration**
   - Add actual Stripe/PayPal API keys
   - Implement webhook handling
   - Add payment failure handling

2. **Email Notifications**
   - Setup SMTP configuration
   - Create email templates
   - Send confirmation emails

3. **Admin Dashboard**
   - View appointments
   - Manage bookings
   - Generate reports

4. **Additional Features**
   - Appointment rescheduling
   - SMS notifications
   - Calendar integration
   - Doctor availability system

The application is now fully functional and ready for testing with MySQL database and simulated payment processing!
