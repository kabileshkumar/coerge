<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Book Your Appointment - Coerge Form')</title>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --secondary-gradient: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            --accent-gradient: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            
            --primary-color: #3b82f6;
            --secondary-color: #1d4ed8;
            --accent-color: #0ea5e9;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-accent: #f1f5f9;
            --bg-gradient: linear-gradient(135deg, #ffffff 0%, #dbeafe 50%, #bfdbfe 100%);
            
            --border-radius: 20px;
            --border-radius-sm: 12px;
            --border-radius-lg: 30px;
            
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            
            min-height: 100vh;
            color: var(--text-primary);
            overflow-x: hidden;
        }
        
        
        
        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        
        .form-container {
            background: var(--bg-primary);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            max-width: 600px;
            width: 100%;
            position: relative;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }
        
        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }
        
        .form-header {
            text-align: center;
            padding: 40px 40px 30px;
            background: var(--bg-secondary);
            position: relative;
            overflow: hidden;
        }
        
        .form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-gradient);
            opacity: 0.05;
        }
        
        .form-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .form-header .subtitle {
            color: var(--text-secondary);
            font-size: 16px;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }
        
        .progress-container {
            padding: 30px 40px;
            background: var(--bg-accent);
            position: relative;
        }
        
        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }
        
        .progress-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            height: 3px;
            background: rgba(59, 130, 246, 0.2);
            border-radius: 2px;
            z-index: 1;
        }
        
        .progress-line {
            position: absolute;
            top: 20px;
            left: 20px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 2px;
            z-index: 2;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .step {
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-primary);
            border: 3px solid rgba(59, 130, 246, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }
        
        .step.active .step-circle {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }
        
        .step.completed .step-circle {
            background: var(--success-gradient);
            border-color: transparent;
            color: white;
            transform: scale(1.05);
        }
        
        .step-label {
            font-size: 13px;
            color: var(--text-secondary);
            text-align: center;
            white-space: nowrap;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .step.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .form-body {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
            display: block;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .form-control {
            width: 100%;
            border: 2px solid var(--bg-accent);
            border-radius: var(--border-radius-sm);
            padding: 16px 20px;
            font-size: 15px;
            transition: var(--transition);
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }
        
        .form-control::placeholder {
            color: var(--text-light);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 32px;
            border: none;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--shadow-md);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        
        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }
        
        .btn-lg {
            padding: 18px 36px;
            font-size: 16px;
        }
        
        .google-signin {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            border: 2px solid var(--bg-accent);
            border-radius: var(--border-radius-sm);
            padding: 16px 24px;
            background: var(--bg-primary);
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }
        
        .google-signin:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            text-decoration: none;
            color: var(--text-primary);
        }
        
        .google-signin::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.5s;
        }
        
        .google-signin:hover::before {
            left: 100%;
        }
        
        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--bg-accent);
        }
        
        .divider span {
            background: var(--bg-primary);
            padding: 0 20px;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .alert {
            border-radius: var(--border-radius-sm);
            border: none;
            font-size: 14px;
            padding: 16px 20px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border-left: 4px solid var(--success-color);
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-left: 4px solid var(--danger-color);
        }
        
        .alert-info {
            background: rgba(14, 165, 233, 0.1);
            color: #2563eb;
            border-left: 4px solid var(--accent-color);
        }
        
        .invalid-feedback {
            font-size: 12px;
            margin-top: 6px;
            color: var(--danger-color);
            font-weight: 500;
        }
        
        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
        }
        
        .form-check-input {
            width: 20px;
            height: 20px;
            margin-top: 2px;
            border: 2px solid var(--bg-accent);
            border-radius: 4px;
            transition: var(--transition);
        }
        
        .form-check-input:checked {
            background: var(--primary-gradient);
            border-color: transparent;
        }
        
        .form-check-label {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.5;
            cursor: pointer;
        }
        
        .input-group {
            display: flex;
            gap: 15px;
        }
        
        .phone-code {
            flex: 0 0 120px;
        }
        
        .mobile-input {
            flex: 1;
        }
        
        .position-relative {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 5px;
            transition: var(--transition);
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .section-header {
            border-bottom: 2px solid var(--bg-accent);
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .section-header h5 {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .section-header p {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0;
        }
        
        .payment-summary {
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            padding: 25px;
            border: 2px solid var(--bg-accent);
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius-sm);
            padding: 20px;
            box-shadow: var(--shadow-sm);
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--bg-accent);
        }
        
        .summary-row:last-child {
            border-bottom: none;
        }
        
        .summary-label {
            color: var(--text-secondary);
            font-weight: 500;
        }
        
        .summary-value {
            color: var(--text-primary);
            font-weight: 600;
        }
        
        .total-row {
            font-size: 20px;
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .payment-method {
            position: relative;
        }
        
        .payment-radio {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        
        .payment-label {
            display: flex;
            align-items: center;
            padding: 25px;
            border: 2px solid var(--bg-accent);
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: var(--transition);
            background: var(--bg-primary);
            margin-bottom: 0;
        }
        
        .payment-label:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .payment-radio:checked + .payment-label {
            border-color: var(--primary-color);
            background: rgba(59, 130, 246, 0.05);
            box-shadow: var(--shadow-md);
        }
        
        .payment-icon {
            font-size: 28px;
            width: 60px;
            text-align: center;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .payment-info {
            flex: 1;
            margin-left: 20px;
        }
        
        .payment-title {
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 5px;
            font-size: 16px;
        }
        
        .payment-desc {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 10px;
        }
        
        .payment-cards {
            display: flex;
            gap: 10px;
        }
        
        .payment-cards i {
            font-size: 24px;
            color: var(--text-muted);
        }
        
        .payment-check {
            width: 28px;
            height: 28px;
            border: 2px solid var(--bg-accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: transparent;
            font-size: 12px;
            transition: var(--transition);
        }
        
        .payment-radio:checked + .payment-label .payment-check {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
        }
        
        .success-icon {
            animation: successBounce 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        @keyframes successBounce {
            0% { transform: scale(0) rotate(0deg); }
            50% { transform: scale(1.2) rotate(180deg); }
            100% { transform: scale(1) rotate(360deg); }
        }
        
        .confirmation-card {
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            padding: 25px;
            margin-bottom: 25px;
            border: 2px solid var(--bg-accent);
        }
        
        .card-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            border-bottom: 2px solid var(--bg-accent);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--bg-accent);
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            color: var(--text-secondary);
            font-weight: 500;
            flex: 0 0 40%;
        }
        
        .detail-value {
            color: var(--text-primary);
            font-weight: 600;
            text-align: right;
            flex: 1;
        }
        
        .next-steps {
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            padding: 25px;
            margin-bottom: 25px;
            border: 2px solid var(--bg-accent);
        }
        
        .step-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }
        
        .step-item:last-child {
            margin-bottom: 0;
        }
        
        .step-number {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }
        
        .step-content {
            margin-left: 20px;
            flex: 1;
        }
        
        .step-content strong {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        
        .step-content p {
            margin-bottom: 0;
            margin-top: 5px;
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.6;
        }
        
        .badge {
            font-size: 12px;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .bg-success {
            background: var(--success-gradient);
            color: white;
        }
        
        .contact-info {
            margin-top: 25px;
        }
        
        .contact-methods div {
            margin-bottom: 6px;
            color: var(--text-secondary);
        }
        
        @media (max-width: 768px) {
            .form-container {
                margin: 10px;
                border-radius: var(--border-radius);
            }
            
            .form-header,
            .form-body,
            .progress-container {
                padding-left: 25px;
                padding-right: 25px;
            }
            
            .form-header h1 {
                font-size: 28px;
            }
            
            .step-label {
                font-size: 11px;
            }
            
            .input-group {
                flex-direction: column;
                gap: 10px;
            }
            
            .phone-code {
                flex: none;
            }
            
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .detail-value {
                text-align: left;
            }
        }
        
        @media (max-width: 480px) {
            .form-header h1 {
                font-size: 24px;
            }
            
            .btn {
                padding: 14px 24px;
                font-size: 14px;
            }
            
            .payment-label {
                padding: 20px;
            }
        }
        
        .form-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--bg-accent);
        }
        
        .text-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .text-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--bg-accent);
        }
        
        .divider span {
            background: var(--bg-primary);
            padding: 0 15px;
            color: var(--text-muted);
            font-size: 14px;
        }
    </style>
    
    @stack('styles')
</head>
<body>
   
    
    <div class="main-container">
        <div class="form-container">
            @yield('content')
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // CSRF token setup for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Form validation helper
        function showFieldError(fieldName, message) {
            const field = $(`[name="${fieldName}"]`);
            field.addClass('is-invalid');
            field.siblings('.invalid-feedback').remove();
            field.after(`<div class="invalid-feedback">${message}</div>`);
        }
        
        function clearFieldError(fieldName) {
            const field = $(`[name="${fieldName}"]`);
            field.removeClass('is-invalid');
            field.siblings('.invalid-feedback').remove();
        }
        
        function clearAllErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }
        
        // Progress line animation
        function updateProgressLine(step) {
            const steps = $('.step').length;
            const percentage = ((step - 1) / (steps - 1)) * 100;
            $('.progress-line').css('width', `${percentage}%`);
        }
        
        // Add smooth scroll behavior
        $('html').css('scroll-behavior', 'smooth');
        
        // Add loading states to buttons
        $('form').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            if (submitBtn.length) {
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
