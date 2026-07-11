<?php
    header('Content-Type: application/json');
    require_once __DIR__ . '/owner_info_class.php';
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $owner_info = new OwnerInfo();
        $owner_info->duplicate_email($email);
        $duplicate = $owner->duplicate_email($email);
        echo json_encode((bool)$duplicate);
    }
    
?>