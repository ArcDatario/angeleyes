<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Interface</title>
    <link rel="stylesheet" href="payment.css">
    <link rel="icon" href="angeleyes-logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <h2>Payment Gateway</h2>
            <p>Secure and easy payments</p>
        </div>

        <div class="progress-steps">
            <div class="progress-bar" style="width: 0%;"></div>
            <div class="step" data-step="1">
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

        <div class="payment-body">
            <!-- Step 1: Enter Reference -->
            <div class="step-content active" data-step-content="1">
                <div class="form-group">
                    <label for="reference">Enter your Subscription Reference</label>
                    <input type="text" id="reference" class="form-control" placeholder="e.g. SUB123456789">
                </div>
                <button class="btn btn-primary" onclick="PaymentHandler.verifyReference()">Continue</button>
            </div>

            <!-- Step 2: Verification Method -->
            <div class="step-content" data-step-content="2">
                <div class="user-info">
                    <p>We'll send a verification code to:</p>
                    <div class="user-details">
                        <p><strong>Name:</strong> <span id="user-name"></span></p>
                        <p><strong>Email:</strong> <span id="user-email"></span></p>
                        <p><strong>Phone:</strong> <span id="user-phone"></span></p>
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
                <p style="margin-bottom: 16px; color: var(--dark);">We've sent a 6-digit authentication code to your selected method.</p>
                <div class="form-group">
                    <label>Enter Authentication Code</label>
                    <div class="auth-code-container">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="PaymentHandler.moveToNext(this)">
                    </div>
                    <a href="#" class="resend-link" onclick="PaymentHandler.resendCode()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

            <!-- Step 4: Payment -->
            <!-- Step 4: Payment Confirmation -->
<div class="step-content" data-step-content="4">
    <div class="payment-summary">
        <h3>Invoice Details</h3>
        <div class="summary-row">
            <span>Name:</span>
            <span id="summary-name">-</span>
        </div>
        <div class="summary-row">
            <span>Subscription:</span>
            <span id="summary-plan-name">-</span>
        </div>
        <div class="summary-row">
            <span>Reference:</span>
            <span id="summary-reference">-</span>
        </div>
        <div class="summary-row">
            <span>Amount:</span>
            <span id="summary-amount">-</span>
        </div>
        <div class="summary-row">
            <span>Due Date:</span>
            <span id="summary-due-date">-</span>
        </div>
    </div>
    
    <div class="navigation-buttons">
        <button class="btn btn-secondary" onclick="PaymentHandler.prevStep()">Back</button>
        <button class="btn btn-primary" onclick="PaymentHandler.processPayment()">Proceed to Payment</button>
    </div>
</div>

<!-- Step 5: Redirecting -->
<div class="step-content" data-step-content="5">
    <div class="redirect-message">
        <div class="loading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12a9 9 0 1 1-6.219-8.56" />
            </svg>
        </div>
        <h3>Redirecting to Payment Gateway</h3>
        <p>Please wait while we redirect you to our secure payment processor.</p>
        <p>If you are not redirected automatically, <a href="#" id="manual-redirect-link">click here</a>.</p>
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
    </div>

    <script>
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

            // In the PaymentHandler object:
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

// In the PaymentHandler object:
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

            moveToNext: function(input) {
                if (input.value.length === 1) {
                    const nextInput = input.nextElementSibling;
                    if (nextInput && nextInput.classList.contains('auth-code-input')) {
                        nextInput.focus();
                    }
                }
            },

            setupPaymentMethodDropdown: function() {
                const dropdown = document.getElementById('custom-payment-method');
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