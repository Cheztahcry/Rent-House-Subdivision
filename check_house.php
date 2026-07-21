<?php
    header('Content-Type: application/json');
    ob_clean();
    require_once __DIR__ . '/house_info_class.php';
    $block = trim($_POST['blocknumber'] ?? '');
    $lot = trim($_POST['lotnumber'] ?? '');
    $house_info = new HouseInfo();
    $duplicate_house = $house_info->check_duplicates($block, $lot);
    echo json_encode((bool)$duplicate_house);
    exit;
    

?>