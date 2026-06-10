<?php
session_start();

$timeout = 60; // 1 minute

if (isset($_SESSION['LAST_ACTIVITY']) && 
    (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {
    session_unset();
    session_destroy();
}

$_SESSION['LAST_ACTIVITY'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/forgot_password_style.css">
</head>
<body>
    <div class="forgot-password-page">
        <div class="forgot-password-card">
            <div class="forgot-password-header">
                <h1>Forgot Password</h1>
                <p>Enter your email address to receive a password reset link.</p>
            </div>
            
            <form action="forgot_password_process.php" method="post" id="forgot-form">
                <div class="field-group">
                    <label for="email">Email Address</label>
                    <div class="field-row">
                        <input type="email" name="email" id="email" placeholder="Enter your email" required>
                    </div>
                </div>
                
                <div class="button-row">
                    <button type="submit" name="submit" id="submit">Send Reset Link</button>
                </div>
            </form>
            
            <div class="form-footer">
                <p>Remember your password? <a href="login.php">Back to Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
