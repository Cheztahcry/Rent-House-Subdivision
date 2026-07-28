<?php
    header('Content-Type: application/json');
    ob_clean();
    require_once __DIR__ . '/login_class.php';
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $cookies = isset($_POST['cookies']) && ($_POST['cookies'] === 'true' || $_POST['cookies'] === 'on');
    $user = new AccountInfo();
    $user_info = $user->check_credentials($email, $password, $cookies);
    echo json_encode((bool)$user_info);
    exit;
    

?>