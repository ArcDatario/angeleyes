<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <link rel="icon" href="angeleyes-logo.png">
    <style>
        :root {
            --primary: #1cb4dc;
            --primary-light: #6366f1;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
            --border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 0;
            margin: 0;
            color: var(--dark);
        }

        .payment-header {
            text-align: center;
            padding: 30px 20px 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
        }

        .payment-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .payment-header p {
            opacity: 0.9;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .payment-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 20px;
            width: 100%;
            background-color: transparent;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            width: 90%;
            max-width: 800px;
            margin: 0 auto 40px;
            padding: 0 50px;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50px;
            right: 50px;
            height: 6px;
            background-color: var(--border);
            transform: translateY(-50%);
            z-index: 1;
            border-radius: 3px;
        }

        .progress-bar {
            position: absolute;
            top: 50%;
            left: 50px;
            height: 6px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            transform: translateY(-50%);
            z-index: 2;
            border-radius: 3px;
            transition: width 0.4s ease;
            width: 0%;
        }

        .step {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: white;
            border: 3px solid var(--border);
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            color: var(--gray);
            position: relative;
            z-index: 3;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .step.active {
            border-color: var(--primary);
            background-color: white;
            color: var(--primary);
            transform: scale(1.1);
        }

        .step.completed {
            border-color: var(--primary);
            background-color: var(--primary);
            color: white;
        }

        .step-label {
            position: absolute;
            top: calc(100% + 12px);
            left: 50%;
            transform: translateX(-50%);
            font-size: 1rem;
            color: var(--gray);
            white-space: nowrap;
            font-weight: 500;
        }

        .step.active .step-label,
        .step.completed .step-label {
            font-weight: 600;
            color: var(--primary);
        }

        .step-content {
            background: white;
            border-radius: 16px;
            padding: 40px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            display: none;
            animation: fadeIn 0.5s ease;
            color: var(--dark);
            border: 1px solid var(--border);
        }

        .step-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 28px;
        }

        .form-group label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background-color: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(28, 180, 220, 0.1);
        }

        .auth-code-container {
            display: flex;
            gap: 9px;
            margin-bottom: 20px;
            justify-content: center;
        }

        .auth-code-input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 28px;
            border: 2px solid var(--border);
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .auth-code-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(28, 180, 220, 0.1);
            outline: none;
        }

        .resend-link {
            color: var(--primary);
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .resend-link:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .payment-summary {
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border: 2px solid var(--border);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 1.1rem;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 16px;
            border-top: 2px solid var(--border);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .success-message {
            text-align: center;
            padding: 30px 0;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background-color: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 30px;
            border: 4px solid var(--success);
        }

        .success-icon svg {
            width: 50px;
            height: 50px;
            color: var(--success);
        }

        .success-message h3 {
            color: var(--dark);
            margin-bottom: 12px;
            font-size: 1.8rem;
        }

        .success-message p {
            color: var(--gray);
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 18px 30px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 1.1rem;
            width: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 5px 15px rgba(28, 180, 220, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(28, 180, 220, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background-color: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            margin-top: 15px;
        }

        .btn-secondary:hover {
            background-color: rgba(28, 180, 220, 0.1);
        }

        .navigation-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .navigation-buttons .btn {
            flex: 1;
        }

        .g-recaptcha {
            margin: 25px 0;
            display: flex;
            justify-content: center;
        }

        .user-info {
            margin-bottom: 25px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 10px;
            border: 2px solid var(--border);
        }

        .user-info p {
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .user-details p {
            margin-bottom: 12px;
            display: flex;
        }

        .user-details strong {
            min-width: 80px;
            display: inline-block;
        }

        .verification-methods {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .method-option {
            display: flex;
            align-items: center;
            padding: 20px;
            border: 2px solid var(--border);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
        }

        .method-option:hover {
            background-color: #f8fafc;
            border-color: var(--primary);
        }

        .method-option input {
            margin-right: 15px;
            transform: scale(1.3);
        }

        .method-option label {
            font-size: 1.1rem;
            font-weight: 500;
            margin: 0;
            cursor: pointer;
        }

        .redirect-message {
            text-align: center;
            padding: 50px 0;
        }

        .loading-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            color: var(--primary);
        }

        .loading-icon svg {
            width: 100%;
            height: 100%;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .footer {
            text-align: center;
            padding: 20px;
            background: #f8fafc;
            font-size: 0.9rem;
            margin-top: auto;
            color: var(--dark);
            border-top: 1px solid var(--border);
        }

        @media (max-width: 768px) {
            .progress-steps {
                padding: 0 20px;
            }
            
            .progress-steps::before {
                left: 20px;
                right: 20px;
            }
            
            .progress-bar {
                left: 20px;
            }
            
            .step {
                width: 40px;
                height: 40px;
            }
            
            .step-label {
                font-size: 0.8rem;
            }
            
            .step-content {
                padding: 30px 20px;
            }
            
            .auth-code-input {
                width: 45px;
                height: 55px;
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="payment-header">
        <h3>Secure Payment Gateway</h3>
       
    </div>

    <div class="payment-content">
        <div class="progress-steps">
            <div class="progress-bar"></div>
            <div class="step active" data-step="1">
                <span>1</span>
                <span class="step-label">Reference</span>
            </div>
            <div class="step" data-step="2">
                <span>2</span>
                <span class="step-label">Verify</span>
            </div>
            <div class="step" data-step="3">
                <span>3</span>
                <span class="step-label">Code</span>
            </div>
            <div class="step" data-step="4">
                <span>4</span>
                <span class="step-label">Pay</span>
            </div>
            <div class="step" data-step="5">
                <span>5</span>
                <span class="step-label">Finish</span>
            </div>
        </div>

        <!-- Step 1: Enter Reference -->
        <div class="step-content active" data-step-content="1">
            <div class="form-group">
                <label for="reference">Enter your Subscription Reference</label>
                <input type="text" id="reference" class="form-control" placeholder="e.g. SUB123456789">
            </div>
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
            <button class="btn btn-primary" onclick="PaymentHandler.verifyReference()">Continue</button>
        </div>

        <!-- Step 2: Verification Method -->
        <div class="step-content" data-step-content="2">
            <div class="user-info">
                <p>We'll send a verification code to:</p>
                <div class="user-details">
                    <p><strong>Name:</strong> <span id="user-name">John Doe</span></p>
                    <p><strong>Email:</strong> <span id="user-email">john.doe@example.com</span></p>
                    <p><strong>Phone:</strong> <span id="user-phone">+1 (555) 123-4567</span></p>
                </div>
            </div>
            <div class="form-group">
                <label>Select verification method:</label>
                <div class="verification-methods">
                    <div class="method-option" onclick="PaymentHandler.selectMethod('email')">
                        <input type="radio" name="verification_method" id="method-email" value="email">
                        <label for="method-email">Send code via Email</label>
                    </div>
                    <div class="method-option" onclick="PaymentHandler.selectMethod('sms')">
                        <input type="radio" name="verification_method" id="method-sms" value="sms" checked>
                        <label for="method-sms">Send code via SMS</label>
                    </div>
                </div>
            </div>
            <div class="navigation-buttons">
                <button class="btn btn-secondary" onclick="PaymentHandler.prevStep()">Back</button>
                <button class="btn btn-primary" onclick="PaymentHandler.sendVerification()">Send Code</button>
            </div>
        </div>

        <!-- Step 3: Enter Verification Code -->
        <div class="step-content" data-step-content="3">
            <p style="margin-bottom: 20px; color: var(--dark);">We've sent a 6-digit authentication code to your selected method.</p>
            <div class="form-group">
                <label>Enter Authentication Code</label>
                <div class="auth-code-container">
                    <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this, event)" onkeydown="PaymentHandler.handleBackspace(this, event)">
                    <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this, event)" onkeydown="PaymentHandler.handleBackspace(this, event)">
                    <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this, event)" onkeydown="PaymentHandler.handleBackspace(this, event)">
                    <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this, event)" onkeydown="PaymentHandler.handleBackspace(this, event)">
                    <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this, event)" onkeydown="PaymentHandler.handleBackspace(this, event)">
                    <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this, event)" onkeydown="PaymentHandler.handleBackspace(this, event)">
                </div>
                <a href="#" class="resend-link" onclick="PaymentHandler.resendCode()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21.5 2v6h-6M2.5 22v-6h6M22 12.5a10 10 0 0 1-10 10 10 10 0 0 1-10-10 10 10 0 0 1 10-10 10 10 0 0 1 10 10z"/>
                    </svg>
                    Resend Code
                </a>
            </div>
            <div class="navigation-buttons">
                <button class="btn btn-secondary" onclick="PaymentHandler.prevStep()">Back</button>
                <button class="btn btn-primary" onclick="PaymentHandler.verifyCode()">Verify</button>
            </div>
        </div>

        <!-- Step 4: Payment Confirmation -->
        <div class="step-content" data-step-content="4">
            <div class="payment-summary">
                <h3 style="margin-bottom: 20px; text-align: center;">Invoice Details</h3>
                <div class="summary-row">
                    <span>Name:</span>
                    <span id="summary-name">John Doe</span>
                </div>
                <div class="summary-row">
                    <span>Subscription:</span>
                    <span id="summary-plan-name">Premium Annual Plan</span>
                </div>
                <div class="summary-row">
                    <span>Reference:</span>
                    <span id="summary-reference">SUB123456789</span>
                </div>
                <div class="summary-row">
                    <span>Amount:</span>
                    <span id="summary-amount">₱1,499.00</span>
                </div>
                <div class="summary-row">
                    <span>Due Date:</span>
                    <span id="summary-due-date">Dec 31, 2023</span>
                </div>
            </div>
            
            <div class="navigation-buttons">
                <button class="btn btn-secondary" onclick="PaymentHandler.prevStep()">Back</button>
                <button class="btn btn-primary" onclick="PaymentHandler.processPayment()">Proceed to Payment</button>
            </div>
        </div>

        <!-- Step 5: Finish -->
        <div class="step-content" data-step-content="5">
            <div class="success-message">
                <div class="success-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h3>Payment Successful!</h3>
                <p id="success-message-amount">Your payment of ₱1,499.00 has been processed successfully.</p>
                <p>Transaction ID: <span id="transaction-id">TXN789456123</span></p>
                <button class="btn btn-primary" onclick="PaymentHandler.resetPayment()">Done</button>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>© 2023 Secure Payment Gateway. All rights reserved.</p>
    </div>

    <script>
        // PaymentHandler object from payment.js
        const PaymentHandler = {
            currentStep: 1,
            selectedMethod: 'sms',
            selectedPaymentMethod: "GCASH",
            subscriptionData: null,

            init: function() {
                this.setupPaymentMethodDropdown();
                this.updateProgressBar();
            },

            updateProgressBar: function() {
                const progressPercentage = ((this.currentStep - 1) / 4) * 100;
                document.querySelector('.progress-bar').style.width = `${progressPercentage}%`;

                // Update step indicators
                document.querySelectorAll('.step').forEach((step, index) => {
                    step.classList.remove('active', 'completed');
                    const stepNumber = parseInt(step.dataset.step);

                    if (stepNumber < this.currentStep) {
                        step.classList.add('completed');
                    } else if (stepNumber === this.currentStep) {
                        step.classList.add('active');
                    }
                });

                // Update step content visibility
                document.querySelectorAll('.step-content').forEach(content => {
                    content.classList.remove('active');
                    if (parseInt(content.dataset.stepContent) === this.currentStep) {
                        content.classList.add('active');
                    }
                });

                // Update payment summary if we have the data
                if (this.subscriptionData && this.currentStep === 4) {
                    document.getElementById('summary-plan-name').textContent = this.subscriptionData.plan_name;
                    document.getElementById('summary-reference').textContent = this.subscriptionData.reference;
                    document.getElementById('summary-amount').textContent = '₱' + parseFloat(this.subscriptionData.price).toFixed(2);
                    document.getElementById('summary-due-date').textContent = new Date(this.subscriptionData.due_date).toLocaleDateString();
                }
                
                // Focus on first input when reaching step 3
                this.focusFirstInput();
            },

            verifyReference: function() {
                const reference = document.getElementById('reference').value.trim();
                if (!reference) {
                    alert('Please enter your subscription reference');
                    return;
                }

                $.ajax({
                    url: 'payment_ajax.php',
                    type: 'POST',
                    data: {
                        ajax_action: 'verify_reference',
                        reference: reference
                    },
                    success: (response) => {
                        if (response.success) {
                            // Store the complete subscription data including plan details
                            this.subscriptionData = response.subscription;
                            document.getElementById('user-name').textContent = response.user.name;
                            document.getElementById('user-email').textContent = response.user.email;
                            document.getElementById('user-phone').textContent = response.user.phone;
                            this.currentStep = 2;
                            this.updateProgressBar();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: () => {
                        alert('An error occurred. Please try again.');
                    }
                });
            },

            selectMethod: function(method) {
                this.selectedMethod = method;
                document.getElementById(`method-${method}`).checked = true;
            },

            sendVerification: function() {
                $.ajax({
                    url: 'payment_ajax.php',
                    type: 'POST',
                    data: {
                        ajax_action: 'send_verification',
                        method: this.selectedMethod
                    },
                    success: (response) => {
                        if (response.success) {
                            this.currentStep = 3;
                            this.updateProgressBar();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: () => {
                        alert('An error occurred. Please try again.');
                    }
                });
            },

            resendCode: function() {
                this.sendVerification();
                alert('New verification code sent!');
            },

            verifyCode: function() {
                const codeInputs = document.querySelectorAll('.auth-code-input');
                const code = Array.from(codeInputs).map(input => input.value).join('');
                
                if (code.length !== 6) {
                    alert('Please enter the full 6-digit code');
                    return;
                }

                $.ajax({
                    url: 'payment_ajax.php',
                    type: 'POST',
                    data: {
                        ajax_action: 'verify_code',
                        code: Array.from(codeInputs).map(input => input.value)
                    },
                    success: (response) => {
                        if (response.success) {
                            // Update all summary information
                            document.getElementById('summary-name').textContent = response.subscription.full_name;
                            document.getElementById('summary-plan-name').textContent = response.subscription.plan_name;
                            document.getElementById('summary-reference').textContent = response.subscription.reference;
                            document.getElementById('summary-amount').textContent = '₱' + parseFloat(response.subscription.price).toFixed(2);
                            document.getElementById('summary-due-date').textContent = new Date(response.subscription.due_date).toLocaleDateString();
                            
                            this.currentStep = 4;
                            this.updateProgressBar();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: () => {
                        alert('An error occurred. Please try again.');
                    }
                });
            },

            processPayment: function() {
                $.ajax({
                    url: 'payment_ajax.php',
                    type: 'POST',
                    data: {
                        ajax_action: 'process_payment'
                    },
                    success: (response) => {
                        if (response.success) {
                            this.currentStep = 5;
                            this.updateProgressBar();
                            
                            // Update success message with transaction details
                            if (response.transaction_data) {
                                const amountFormatted = '₱' + parseFloat(response.transaction_data.amount).toFixed(2);
                                document.getElementById('success-message-amount').textContent = 
                                    `Your payment of ${amountFormatted} for ${response.transaction_data.plan_name} has been processed successfully.`;
                                document.getElementById('transaction-id').textContent = response.transaction_data.reference;
                            }
                            
                            // Store the payment URL for manual redirect
                            const paymentUrl = response.payment_url;
                            document.getElementById('manual-redirect-link').href = paymentUrl;
                            
                            // Start polling for payment status
                            this.pollPaymentStatus();
                            
                            // Redirect after a short delay
                            setTimeout(() => {
                                window.open(paymentUrl, '_blank');
                            }, 2000);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: () => {
                        alert('An error occurred. Please try again.');
                    }
                });
            },

            pollPaymentStatus: function() {
                const checkInterval = setInterval(() => {
                    $.ajax({
                        url: 'payment_ajax.php',
                        type: 'POST',
                        data: {
                            ajax_action: 'check_payment_status'
                        },
                        success: (response) => {
                            if (response.success && response.paid) {
                                clearInterval(checkInterval);
                                // Update UI to show payment success
                                document.querySelector('.redirect-message').style.display = 'none';
                                document.querySelector('.success-message').style.display = 'block';
                            }
                        },
                        error: () => {
                            clearInterval(checkInterval);
                        }
                    });
                }, 3000); // Check every 3 seconds
            },

            nextStep: function() {
                if (this.currentStep < 5) {
                    this.currentStep++;
                    this.updateProgressBar();
                }
            },

            prevStep: function() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                    this.updateProgressBar();
                }
            },

            resetPayment: function() {
                this.currentStep = 1;
                this.subscriptionData = null;
                this.updateProgressBar();
                document.getElementById('reference').value = '';
                document.querySelectorAll('.auth-code-input').forEach(input => input.value = '');
                window.location.href = 'payment.php'; // Reload to clear session
            },

            handleBackspace: function(input, event) {
                if (event.key === 'Backspace' && input.value === '') {
                    const prevInput = input.previousElementSibling;
                    if (prevInput && prevInput.classList.contains('auth-code-input')) {
                        prevInput.focus();
                        prevInput.value = '';
                    }
                }
            },

            moveToNext: function(input, event) {
                if (input.value.length === 1) {
                    const nextInput = input.nextElementSibling;
                    if (nextInput && nextInput.classList.contains('auth-code-input')) {
                        nextInput.focus();
                    }
                }
                
                // Handle backspace key
                if (event && event.key === 'Backspace' && input.value === '') {
                    const prevInput = input.previousElementSibling;
                    if (prevInput && prevInput.classList.contains('auth-code-input')) {
                        prevInput.focus();
                    }
                }
            },
            
            focusFirstInput: function() {
                if (this.currentStep === 3) {
                    // Small delay to ensure the step is visible before focusing
                    setTimeout(() => {
                        const firstInput = document.querySelector('.auth-code-input');
                        if (firstInput) {
                            firstInput.focus();
                        }
                    }, 100);
                }
            },
            
            setupPaymentMethodDropdown: function() {
                const dropdown = document.getElementById('custom-payment-method');
                if (!dropdown) return;
                
                const selected = dropdown.querySelector('.custom-dropdown-selected');
                const options = dropdown.querySelector('.custom-dropdown-options');
                const optionItems = options.querySelectorAll('.custom-dropdown-option');

                function toggleDropdown(e) {
                    dropdown.classList.toggle('open');
                }

                function closeDropdown(e) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('open');
                    }
                }

                optionItems.forEach(option => {
                    option.addEventListener('click', () => {
                        optionItems.forEach(opt => opt.classList.remove('selected'));
                        option.classList.add('selected');

                        const imgSrc = option.getAttribute('data-img');
                        const value = option.getAttribute('data-value');
                        selected.querySelector('img').src = imgSrc;
                        selected.querySelector('img').alt = value;
                        selected.querySelector('span').textContent = value;
                        this.selectedPaymentMethod = value;

                        dropdown.classList.remove('open');
                    });
                });

                selected.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleDropdown();
                    }
                });

                selected.addEventListener('click', toggleDropdown);
                document.addEventListener('click', closeDropdown);
            }
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            PaymentHandler.init();
        });
    </script>
</body>
</html>