<?php
    header('Content-Type: application/json');
    ob_clean();
    require_once __DIR__ . '/login_class.php';
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $user = new AccountInfo();
    $user_info = $user->check_credentials($email, $password);
    echo json_encode((bool)$user_info);
    exit;
    

?>