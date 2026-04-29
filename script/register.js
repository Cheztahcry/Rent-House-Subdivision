// Form validation and submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const alertBox = document.getElementById('alertBox');
    const successBox = document.getElementById('successBox');

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Clear previous messages
        alertBox.classList.remove('show');
        successBox.classList.remove('show');

        // Validate form
        if (!validateForm()) {
            return;
        }

        // Prepare form data
        const formData = new FormData(form);

        try {
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';

            // Send request
            const response = await fetch('process_register.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            submitBtn.disabled = false;
            submitBtn.textContent = originalText;

            if (result.success) {
                // Show success message
                showSuccessMessage(result.message);
                form.reset();
                clearErrors();

                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = 'dashboard.php?owner_id=' + result.owner_id;
                }, 2000);
            } else {
                if (result.errors) {
                    // Display field errors
                    displayErrors(result.errors);
                } else {
                    // Display general error
                    showErrorMessage(result.message);
                }
            }
        } catch (error) {
            showErrorMessage('Error: ' + error.message);
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit Registration';
        }
    });

    // Validate form on client side
    function validateForm() {
        clearErrors();
        const errors = {};

        // Get form values
        const lname = document.getElementById('lname').value.trim();
        const fname = document.getElementById('fname').value.trim();
        const email = document.getElementById('email').value.trim();
        const contactNumber = document.getElementById('contact_number').value.trim();
        const age = parseInt(document.getElementById('age').value) || 0;
        const genderChecked = document.querySelector('input[name="gender"]:checked');
        const block = parseInt(document.getElementById('block').value) || 0;
        const lot = parseInt(document.getElementById('lot').value) || 0;
        const rentPrice = parseFloat(document.getElementById('rent_price').value) || 0;
        const downPayment = parseFloat(document.getElementById('down_payment').value) || 0;
        const moveInDate = document.getElementById('move_in_date').value;
        const leaseTerms = parseInt(document.getElementById('lease_terms').value) || 0;
        const agreeTerms = document.getElementById('agree_terms').checked;

        // Validate Last Name
        if (!lname) {
            errors.lname = 'Last name is required';
        } else if (lname.length > 50) {
            errors.lname = 'Last name cannot exceed 50 characters';
        }

        // Validate First Name
        if (!fname) {
            errors.fname = 'First name is required';
        } else if (fname.length > 50) {
            errors.fname = 'First name cannot exceed 50 characters';
        }

        // Validate Email
        if (!email) {
            errors.email = 'Email is required';
        } else if (!isValidEmail(email)) {
            errors.email = 'Invalid email format';
        }

        // Validate Contact Number
        if (!contactNumber) {
            errors.contact_number = 'Contact number is required';
        } else if (!/^\d{11}$/.test(contactNumber)) {
            errors.contact_number = 'Contact number must be 11 digits';
        }

        // Validate Age
        if (!age) {
            errors.age = 'Age is required';
        } else if (age < 18 || age > 120) {
            errors.age = 'Age must be between 18 and 120';
        }

        // Validate Gender
        if (!genderChecked) {
            errors.gender = 'Gender is required';
        }

        // Validate Block
        if (!block) {
            errors.block = 'Block number is required';
        } else if (block < 1) {
            errors.block = 'Block number must be positive';
        }

        // Validate Lot
        if (!lot) {
            errors.lot = 'Lot number is required';
        } else if (lot < 1) {
            errors.lot = 'Lot number must be positive';
        }

        // Validate Rent Price
        if (!rentPrice) {
            errors.rent_price = 'Monthly rent price is required';
        } else if (rentPrice < 0) {
            errors.rent_price = 'Rent price cannot be negative';
        }

        // Validate Down Payment
        if (!downPayment) {
            errors.down_payment = 'Down payment is required';
        } else if (downPayment < 0) {
            errors.down_payment = 'Down payment cannot be negative';
        }

        // Validate Move-in Date
        if (!moveInDate) {
            errors.move_in_date = 'Move-in date is required';
        } else {
            const selectedDate = new Date(moveInDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (selectedDate < today) {
                errors.move_in_date = 'Move-in date cannot be in the past';
            }
        }

        // Validate Lease Terms
        if (!leaseTerms) {
            errors.lease_terms = 'Lease terms is required';
        } else if (leaseTerms < 1 || leaseTerms > 60) {
            errors.lease_terms = 'Lease terms must be between 1 and 60 months';
        }

        // Validate Agreement
        if (!agreeTerms) {
            errors.agree_terms = 'You must agree to the terms and conditions';
        }

        if (Object.keys(errors).length > 0) {
            displayErrors(errors);
            return false;
        }

        return true;
    }

    // Display validation errors
    function displayErrors(errors) {
        for (const field in errors) {
            const errorElement = document.getElementById(field + '-error');
            const inputElement = document.getElementById(field);

            if (errorElement) {
                errorElement.textContent = errors[field];
                errorElement.classList.add('show');
            }

            if (inputElement) {
                inputElement.classList.add('error');
                inputElement.addEventListener('focus', function() {
                    inputElement.classList.remove('error');
                    errorElement.classList.remove('show');
                });
            }
        }
    }

    // Clear error messages
    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => {
            el.classList.remove('show');
            el.textContent = '';
        });

        document.querySelectorAll('input, select').forEach(el => {
            el.classList.remove('error');
        });
    }

    // Show error alert
    function showErrorMessage(message) {
        alertBox.innerHTML = '<strong>Error:</strong> ' + message;
        alertBox.classList.add('show');
        alertBox.classList.remove('alert-success');
        alertBox.classList.add('alert-danger');
        window.scrollTo(0, 0);
    }

    // Show success message
    function showSuccessMessage(message) {
        successBox.innerHTML = '<strong>Success!</strong> ' + message;
        successBox.classList.add('show');
        window.scrollTo(0, 0);
    }

    // Email validation
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Clear button functionality
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        clearErrors();
        alertBox.classList.remove('show');
        successBox.classList.remove('show');
    });

    // Real-time validation on input
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], input[type="date"]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            const errorElement = document.getElementById(this.name + '-error');
            if (errorElement && this.classList.contains('error')) {
                this.classList.remove('error');
                errorElement.classList.remove('show');
            }
        });
    });

    // Format contact number input
    const contactInput = document.getElementById('contact_number');
    if (contactInput) {
        contactInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);
        });
    }

    // Set minimum date to today
    const moveInDateInput = document.getElementById('move_in_date');
    if (moveInDateInput) {
        const today = new Date().toISOString().split('T')[0];
        moveInDateInput.min = today;
    }
});