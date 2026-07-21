<?php
    header('Content-Type: application/json');
    ob_clean();
    require_once __DIR__ . '/house_info_class.php';
    require_once __DIR__ . '/owner_info_class.php';
    $block = trim($_POST['blocknumber'] ?? '');
    $lot = trim($_POST['lotnumber'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $house_info = new HouseInfo();
    $owner_info = new OwnerInfo();
    $duplicate_house = $house_info->check_duplicates($block, $lot);
    $duplicate_email = $owner->duplicate_email($email);
    $duplicates = [
        'house' => (bool)$duplicate_house,
        'email' => (bool)$duplicate_email     
    ];
    echo json_encode($duplicates);
    exit;
    

?>