<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Information</title>
    <link rel="stylesheet" href="css/owner_info_style.css">
</head>
<body>
    <div class="student form">
        <div class="container">
            <div class="page-header">
                <nav class="page-nav">
                    <a class="nav-link" href="index.php">Home</a>
                    <a class="nav-link" href="login.php">Login</a>
                </nav>
            </div>
            <h1>Owner Information</h1>
            <form action="owner_info_class.php" method="post" id="owner-enrollment">
                <div class="field-group">
                    <label>Full Name</label>
                    <div class="field-row">
                        <input type="text" name="lname" placeholder="Last Name" required>
                        <input type="text" name="fname" placeholder="First Name" required>
                        <input type="text" name="mname" id="mname" placeholder="Middle Name">
                        <label class="checkbox-label">
                            <input type="checkbox" name="check_mname" id="check_mname" value="N/A"> I have no middle name
                        </label>
                    </div>
                </div>
                <div class="field-group">
                    <label>Age</label>
                    <div class="field-row">
                        <input type="number" name="age" id="age" placeholder="Age" min="1">
                    </div>
                </div>
                <div class="field-group">
                    <label>Gender</label>
                    <div class="field-row">
                        <label>
                            <input type="radio" name="gender" value="Male"> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Female"> Female
                        </label>
                    </div>
                </div>
                <div class="field-group">
                    <label for="contact_number">Contact Number</label>
                    <div class="field-row">
                        <input type="tel" name="contactnumber" id="contact_number" placeholder="Contact Number" maxlength="11">
                    </div>
                </div>
                <div class="field-group">
                    <label for="username">Enter Valid Email</label>
                    <div class="field-row">
                        <input type="text" name="email" id="username" placeholder="Email">
                    </div>
                </div>
                <div class="field-group">
                    <label for="password">Create Password</label>
                    <div class="field-row">
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                </div>
                <div class="field-group">
                    <label for="password">Confirm Password</label>
                    <div class="field-row">
                        <input type="password" name="confirm_password" id="password" placeholder="Password">
                    </div>
                </div>
                
                <div class="button-row">
                    <button type="submit" name="submit_owner" id="submit">Next Section</button>
                    <button type="button" id="clear">Clear Fields</button>
                </div>
            </form>
        </div>
    </div>
    <script src="js/owner_info.js"></script>
</body>
</html>