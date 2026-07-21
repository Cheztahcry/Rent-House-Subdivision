<?php
    header('Content-Type: application/json');
    ob_clean();
    require_once __DIR__ . '/owner_info_class.php';
    $email = trim(($_POST['email'] ?? null));
    $owner_info = new OwnerInfo();
    $duplicate_email = $owner->duplicate_email($email);
    echo json_encode((bool)$duplicate_email);
    exit;
    

?>