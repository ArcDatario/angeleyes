
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Interface</title>
    <link rel="stylesheet" href="payment.css">
    <link rel="icon" href="angeleyes-logo.png">
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
                <span class="step-label">Account ID</span>
            </div>
            <div class="step" data-step="2">
                <span>2</span>
                <span class="step-label">Confirm</span>
            </div>
            <div class="step" data-step="3">
                <span>3</span>
                <span class="step-label">Invoice</span>
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
            <!-- Step 1: Enter Account ID -->
            <div class="step-content active" data-step-content="1">
                <div class="form-group">
                    <label for="account-id">Enter your Account ID</label>
                    <input type="text" id="account-id" class="form-control" placeholder="e.g. ACC123456789">
                </div>
                <button class="btn btn-primary" onclick="nextStep()">Continue</button>
            </div>

            <!-- Step 2: Confirm Account -->
            <div class="step-content" data-step-content="2">
                <p style="margin-bottom: 16px; color: var(--dark);">We've sent a 6-digit authentication code to your registered email and phone number.</p>
                <div class="form-group">
                    <label>Enter Authentication Code</label>
                    <div class="auth-code-container">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="moveToNext(this)">
                        <input type="text" maxlength="1" class="auth-code-input" oninput="moveToNext(this)">
                    </div>
                    <a href="#" class="resend-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.5 2v6h-6M2.5 22v-6h6M22 12.5a10 10 0 0 1-10 10 10 10 0 0 1-10-10 10 10 0 0 1 10-10 10 10 0 0 1 10 10z"/>
                        </svg>
                        Resend Code
                    </a>
                </div>
                <div class="navigation-buttons">
                    <button class="btn btn-secondary" onclick="prevStep()">Back</button>
                    <button class="btn btn-primary" onclick="nextStep()">Verify</button>
                </div>
            </div>

            <!-- Step 3: Select Invoice -->
            <div class="step-content" data-step-content="3">
                <div class="form-group">
                    <label>Select Invoice to Pay</label>
                    <div class="invoice-list">
                        <div class="invoice-item selected" data-title="Monthly Subscription" data-amount="₱1,499.00">
                            <div class="invoice-info">
                                <span class="invoice-title">Monthly Subscription</span>
                                <span class="invoice-date">Due: May 15, 2023</span>
                            </div>
                            <span class="invoice-amount">₱1,499.00</span>
                        </div>
                        <!-- <div class="invoice-item" data-title="Service Fee" data-amount="₱12.50">
                            <div class="invoice-info">
                                <span class="invoice-title">Service Fee</span>
                                <span class="invoice-date">Due: June 1, 2023</span>
                            </div>
                            <span class="invoice-amount">₱12.50</span>
                        </div>
                        <div class="invoice-item" data-title="Annual Renewal" data-amount="₱299.00">
                            <div class="invoice-info">
                                <span class="invoice-title">Annual Renewal</span>
                                <span class="invoice-date">Due: July 10, 2023</span>
                            </div>
                            <span class="invoice-amount">₱299.00</span>
                        </div> -->
                    </div>
                </div>
                <div class="navigation-buttons">
                    <button class="btn btn-secondary" onclick="prevStep()">Back</button>
                    <button class="btn btn-primary" onclick="nextStep()">Continue to Payment</button>
                </div>
            </div>

            <!-- Step 4: Pay -->
            <div class="step-content" data-step-content="4">
                <div class="payment-summary">
                    <div class="summary-row">
                        <span>Invoice:</span>
                        <span id="summary-invoice-title">Monthly Subscription</span>
                    </div>
                    <div class="summary-row">
                        <span>Amount:</span>
                        <span id="summary-invoice-amount">₱1,499.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Payment Method:</span>
                        <span id="summary-payment-method">GCash</span>
                    </div>
                    <div class="summary-row">
                        <span>Total:</span>
                        <span id="summary-total-amount">₱1,499.00</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Select Payment Method</label>

<!-- Modern Interactive Payment Method Dropdown (Dropdown Opens Upward) -->
<style>
    .payment-method-dropdown-container {
        max-width: 350px;
        margin: 0 auto;
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .custom-dropdown {
        position: relative;
        width: 100%;
        user-select: none;
    }
    .custom-dropdown-selected {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border: 1.5px solid #4f8cff;
        border-radius: 8px;
        background: #f8faff;
        cursor: pointer;
        transition: box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.07);
    }
    .custom-dropdown-selected:hover, .custom-dropdown.open .custom-dropdown-selected {
        box-shadow: 0 4px 16px rgba(79, 140, 255, 0.13);
        background: #f0f6ff;
    }
    .custom-dropdown-selected img {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        margin-right: 14px;
    }
    .custom-dropdown-selected span {
        font-size: 1.08rem;
        font-weight: 500;
        color: #2a3a4b;
    }
    .custom-dropdown-arrow {
        margin-left: auto;
        font-size: 1.2rem;
        color: #4f8cff;
        transition: transform 0.2s;
    }
    .custom-dropdown.open .custom-dropdown-arrow {
        transform: rotate(-180deg);
    }
    /* Dropdown options appear above the trigger */
    .custom-dropdown-options {
        position: absolute;
        bottom: 110%;
        left: 0;
        width: 100%;
        background: #fff;
        border: 1.5px solid #4f8cff;
        border-radius: 8px 8px 0 0;
        box-shadow: 0 -8px 24px rgba(79, 140, 255, 0.13);
        z-index: 10;
        display: none;
        animation: fadeInUp 0.18s;
    }
    .custom-dropdown.open .custom-dropdown-options {
        display: block;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(8px);}
        to { opacity: 1; transform: translateY(0);}
    }
    .custom-dropdown-option {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        cursor: pointer;
        transition: background 0.15s;
    }
    .custom-dropdown-option img {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        margin-right: 12px;
    }
    .custom-dropdown-option span {
        font-size: 1rem;
        color: #2a3a4b;
    }
    .custom-dropdown-option:hover, .custom-dropdown-option.selected {
        background: #e6f0ff;
    }
</style>

<div class="payment-method-dropdown-container">
   
    <div class="custom-dropdown" id="custom-payment-method">
        <div class="custom-dropdown-selected" tabindex="0">
            <img src="images/gcash.jfif" alt="GCash">
            <span>GCash</span>
            <span class="custom-dropdown-arrow">&#9662;</span>
        </div>
        <div class="custom-dropdown-options">
            <div class="custom-dropdown-option selected" data-value="GCash" data-img="images/gcash.jfif">
                <img src="images/gcash.jfif" alt="GCash">
                <span>GCash</span>
            </div>
            <div class="custom-dropdown-option" data-value="PayMaya" data-img="images/paymaya.png">
                <img src="images/paymaya.png" alt="PayMaya">
                <span>PayMaya</span>
            </div>
            <div class="custom-dropdown-option" data-value="GrabPay" data-img="images/grabpay.png">
                <img src="images/grabpay.png" alt="GrabPay">
                <span>GrabPay</span>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const dropdown = document.getElementById('custom-payment-method');
    const selected = dropdown.querySelector('.custom-dropdown-selected');
    const options = dropdown.querySelector('.custom-dropdown-options');
    const optionItems = options.querySelectorAll('.custom-dropdown-option');

    // Toggle dropdown open/close
    function toggleDropdown(e) {
        dropdown.classList.toggle('open');
    }

    // Close dropdown if clicked outside
    function closeDropdown(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    }

    // Select option
    optionItems.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected from all
            optionItems.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');

            // Update selected display
            const imgSrc = this.getAttribute('data-img');
            const value = this.getAttribute('data-value');
            selected.querySelector('img').src = imgSrc;
            selected.querySelector('img').alt = value;
            selected.querySelector('span').textContent = value;

            dropdown.classList.remove('open');
        });
    });

    // Keyboard accessibility
    selected.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleDropdown();
        }
    });

    selected.addEventListener('click', toggleDropdown);
    document.addEventListener('click', closeDropdown);
})();
</script>


    

                </div>
                <div class="navigation-buttons">
                    <button class="btn btn-secondary" onclick="prevStep()">Back</button>
                    <button class="btn btn-primary" onclick="nextStep()">Pay <span id="pay-amount-btn">₱1,499.00</span></button>
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
                    <p>Transaction ID: TXN789456123</p>
                    <button class="btn btn-primary" onclick="resetPayment()">Done</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        let selectedInvoice = {
            title: "Monthly Subscription",
            amount: "₱1,499.00"
        };
        let selectedPaymentMethod = "GCash";

        function updateProgressBar() {
            const progressPercentage = ((currentStep - 1) / 4) * 100;
            document.querySelector('.progress-bar').style.width = `${progressPercentage}%`;

            // Update step indicators
            document.querySelectorAll('.step').forEach((step, index) => {
                step.classList.remove('active', 'completed');
                const stepNumber = parseInt(step.dataset.step);

                if (stepNumber < currentStep) {
                    step.classList.add('completed');
                } else if (stepNumber === currentStep) {
                    step.classList.add('active');
                }
            });

            // Update step content visibility
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.remove('active');
                if (parseInt(content.dataset.stepContent) === currentStep) {
                    content.classList.add('active');
                }
            });

            // Update summary info for payment step
            if (currentStep === 4) {
                document.getElementById('summary-invoice-title').textContent = selectedInvoice.title;
                document.getElementById('summary-invoice-amount').textContent = selectedInvoice.amount;
                document.getElementById('summary-total-amount').textContent = selectedInvoice.amount;
                document.getElementById('summary-payment-method').textContent = selectedPaymentMethod;
                document.getElementById('pay-amount-btn').textContent = selectedInvoice.amount;
            }
            // Update success message
            if (currentStep === 5) {
                document.getElementById('success-message-amount').textContent = `Your payment of ${selectedInvoice.amount} has been processed successfully.`;
            }
        }

        function nextStep() {
            if (currentStep < 5) {
                currentStep++;
                updateProgressBar();
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateProgressBar();
            }
        }

        function resetPayment() {
            currentStep = 1;
            updateProgressBar();

            // Reset form inputs
            document.getElementById('account-id').value = '';
            document.querySelectorAll('.auth-code-input').forEach(input => {
                input.value = '';
            });

            // Reset invoice selection
            document.querySelectorAll('.invoice-item').forEach((item, idx) => {
                item.classList.remove('selected');
                if (idx === 0) item.classList.add('selected');
            });
            selectedInvoice = {
                title: "Monthly Subscription",
                amount: "₱1,499.00"
            };

            // Reset payment method
            document.querySelectorAll('.payment-option').forEach((option, idx) => {
                option.classList.remove('selected');
                if (idx === 0) option.classList.add('selected');
                option.querySelector('input[type="radio"]').checked = idx === 0;
            });
            selectedPaymentMethod = "GCash";
        }

        function moveToNext(input) {
            if (input.value.length === 1) {
                const nextInput = input.nextElementSibling;
                if (nextInput && nextInput.classList.contains('auth-code-input')) {
                    nextInput.focus();
                }
            }
        }

        // Initialize
        updateProgressBar();

        // Invoice selection logic
        document.querySelectorAll('.invoice-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.invoice-item').forEach(i => {
                    i.classList.remove('selected');
                });
                this.classList.add('selected');
                selectedInvoice = {
                    title: this.getAttribute('data-title'),
                    amount: this.getAttribute('data-amount')
                };
            });
        });

        // Payment method selection logic
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function(e) {
                document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
                selectedPaymentMethod = this.getAttribute('data-method');
            });
            // Also update on radio change (keyboard navigation)
            option.querySelector('input[type="radio"]').addEventListener('change', function(e) {
                document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
                option.classList.add('selected');
                selectedPaymentMethod = option.getAttribute('data-method');
            });
        });
    </script>
</body>
</html>
