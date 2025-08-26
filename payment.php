<?php
session_start();

// Handle Xendit redirects
if (isset($_GET['success'])) {
    // Payment was successful
    $_SESSION['payment_success'] = true;
    header('Location: payment.php');
    exit;
}

if (isset($_GET['failed'])) {
    // Payment failed
    $_SESSION['payment_error'] = 'Payment failed. Please try again.';
    header('Location: payment.php');
    exit;
}

// Check for success/error messages
$paymentSuccess = isset($_SESSION['payment_success']) ? $_SESSION['payment_success'] : false;
$paymentError = isset($_SESSION['payment_error']) ? $_SESSION['payment_error'] : '';

// Clear the messages after displaying
unset($_SESSION['payment_success']);
unset($_SESSION['payment_error']);
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
                <input type="text" maxlength="1" class="auth-code-input" 
                    oninput="PaymentHandler.moveToNext(this, event)" 
                    onkeydown="PaymentHandler.moveToNext(this, event)">
                <input type="text" maxlength="1" class="auth-code-input" 
                    oninput="PaymentHandler.moveToNext(this, event)" 
                    onkeydown="PaymentHandler.moveToNext(this, event)">
                <input type="text" maxlength="1" class="auth-code-input" 
                    oninput="PaymentHandler.moveToNext(this, event)" 
                    onkeydown="PaymentHandler.moveToNext(this, event)">
                <input type="text" maxlength="1" class="auth-code-input" 
                    oninput="PaymentHandler.moveToNext(this, event)" 
                    onkeydown="PaymentHandler.moveToNext(this, event)">
                <input type="text" maxlength="1" class="auth-code-input" 
                    oninput="PaymentHandler.moveToNext(this, event)" 
                    onkeydown="PaymentHandler.moveToNext(this, event)">
                <input type="text" maxlength="1" class="auth-code-input" 
                    oninput="PaymentHandler.moveToNext(this, event)" 
                    onkeydown="PaymentHandler.moveToNext(this, event)">
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
  
    
    <script src="assets/js/payment.js"></script>
</body>
</html>