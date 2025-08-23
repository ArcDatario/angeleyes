const PaymentHandler = {
            currentStep: 1,
            selectedMethod: 'sms',
            selectedPaymentMethod: "GCASH",
            subscriptionData: null,

           // Add this to your PaymentHandler.init() function
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

           // In the PaymentHandler object, add this new method:
handleBackspace: function(input, event) {
    if (event.key === 'Backspace' && input.value === '') {
        const prevInput = input.previousElementSibling;
        if (prevInput && prevInput.classList.contains('auth-code-input')) {
            prevInput.focus();
            prevInput.value = '';
        }
    }
},

// Also update the moveToNext method:
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