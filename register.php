<!DOCTYPE html>
<html lang="en"
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Registration - Rent House Subdivision</title>
    <link rel="stylesheet" href="css/index.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .section-title {
            color: #667eea;
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 15px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .radio-group,
        .checkbox-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .radio-group label,
        .checkbox-group label {
            display: flex;
            align-items: center;
            margin-bottom: 0;
            cursor: pointer;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        input.error {
            border-color: #e74c3c;
        }

        .button-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 30px;
        }

        button {
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        button[type="submit"] {
            background-color: #667eea;
            color: white;
        }

        button[type="submit"]:hover {
            background-color: #5568d3;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        button[type="reset"] {
            background-color: #95a5a6;
            color: white;
        }

        button[type="reset"]:hover {
            background-color: #7f8c8d;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.show {
            display: block;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .button-group {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>📋 Owner Registration</h1>
        <p style="color: #666; margin-bottom: 30px;">Rent House Subdivision</p>

        <!-- Alert Messages -->
        <div id="alertBox" class="alert"></div>

        <form id="registrationForm" action="process_register.php" method="POST" novalidate>
            
            <!-- Owner Information Section -->
            <div class="section-title">👤 Owner Information</div>

            <div class="form-row">
                <div class="form-group">
                    <label for="lname">Last Name *</label>
                    <input type="text" name="lname" id="lname" placeholder="Enter last name" required>
                    <div class="error-message" id="lname-error"></div>
                </div>
                <div class="form-group">
                    <label for="fname">First Name *</label>
                    <input type="text" name="fname" id="fname" placeholder="Enter first name" required>
                    <div class="error-message" id="fname-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="mname">Middle Name</label>
                <input type="text" name="mname" id="mname" placeholder="Enter middle name">
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" name="email" id="email" placeholder="Enter email address" required>
                <div class="error-message" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number *</label>
                <input type="tel" name="contact_number" id="contact_number" placeholder="09XXXXXXXXX" maxlength="11" pattern="[0-9]{11}" required>
                <div class="error-message" id="contact_number-error"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="age">Age *</label>
                    <input type="number" name="age" id="age" placeholder="Enter age" min="18" max="120" required>
                    <div class="error-message" id="age-error"></div>
                </div>
                <div class="form-group">
                    <label>Gender *</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="gender" value="Male" required> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Female" required> Female
                        </label>
                    </div>
                    <div class="error-message" id="gender-error"></div>
                </div>
            </div>

            <!-- Address Information Section -->
            <div class="section-title"> Address Information</div>

            <div class="form-row">
                <div class="form-group">
                    <label for="block">Block Number *</label>
                    <input type="number" name="block" id="block" placeholder="Block number" min="1" required>
                    <div class="error-message" id="block-error"></div>
                </div>
                <div class="form-group">
                    <label for="lot">Lot Number *</label>
                    <input type="number" name="lot" id="lot" placeholder="Lot number" min="1" required>
                    <div class="error-message" id="lot-error"></div>
                </div>
            </div>

            <!-- Rent House Information Section -->
            <div class="section-title"> Rent House Information</div>

            <div class="form-row">
                <div class="form-group">
                    <label for="rent_price">Monthly Rent Price (₱) *</label>
                    <input type="number" name="rent_price" id="rent_price" placeholder="Enter monthly rent price" min="0" step="0.01" required>
                    <div class="error-message" id="rent_price-error"></div>
                </div>
                <div class="form-group">
                    <label for="down_payment">Down Payment (₱) *</label>
                    <input type="number" name="down_payment" id="down_payment" placeholder="Enter down payment" min="0" step="0.01" required>
                    <div class="error-message" id="down_payment-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="move_in_date">Preferred Move-in Date *</label>
                <input type="date" name="move_in_date" id="move_in_date" required>
                <div class="error-message" id="move_in_date-error"></div>
            </div>

            <div class="form-group">
                <label for="lease_terms">Lease Terms (Months) *</label>
                <input type="number" name="lease_terms" id="lease_terms" placeholder="Enter lease duration in months" min="1" max="60" required>
                <div class="error-message" id="lease_terms-error"></div>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="agree_terms" id="agree_terms" required>
                    I agree to the terms and conditions *
                </label>
                <div class="error-message" id="agree_terms-error"></div>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <button type="submit" name="submit">Submit Registration</button>
                <button type="reset" name="clear">Clear Fields</button>
            </div>

        </form>
    </div>

    <script src="script/register.js"></script>
</body>

</html>
