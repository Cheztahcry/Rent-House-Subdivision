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
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/reset_password_style.css">
</head>
<body>
    <div class="reset-password-page">
        <div class="reset-password-card">
            <div class="reset-password-header">
                <h1>Reset Password</h1>
                <p>Enter your new password below.</p>
            </div>
            
            <form action="reset_password_process.php" method="post" id="reset-form">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">
                
                <div class="field-group">
                    <label for="password">New Password</label>
                    <div class="field-row">
                        <input type="password" name="password" id="password" placeholder="Enter new password (minimum 8 characters)" required>
                    </div>
                </div>
                
                <div class="field-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="field-row">
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required>
                    </div>
                </div>
                
                <div class="button-row">
                    <button type="submit" name="submit" id="submit">Reset Password</button>
                </div>
            </form>
            
            <div class="form-footer">
                <p>Remember your password? <a href="login.php">Back to Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
