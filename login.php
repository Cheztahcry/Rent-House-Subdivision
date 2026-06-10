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
    <title>Login</title>
    <link rel="stylesheet" href="css/login_style.css">
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="page-header">
                <nav class="page-nav">
                    <a class="nav-link" href="index.php">Home</a>
                </nav>
            </div>
            <div class="login-header">
                <h1>Login</h1>
                <p>Access your account by entering your credentials.</p>
            </div>
            <form action="login_class.php" method="post" id="login-form">
                <div class="field-group">
                    <label for="email">Email</label>
                    <div class="field-row">
                        <input type="text" name="email" id="email" placeholder="Email">
                    </div>
                </div>
                <div class="field-group">
                    <label for="password">Password</label>
                    <div class="field-row">
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                </div>
                <div class="button-row">
                    <button type="submit" name="login" id="login">Login</button>
                </div>
                <div class="register-link">
                    <a href="owner_info.php">Register</a>
                </div>
                <div class="forgot-password">
                    <a href="forgot_password.php">Forgot password?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
