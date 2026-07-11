<?php
    
    /*require_once __DIR__ .'/database.php';


    try{
        if (isset($_POST['lotnumber']) && isset($_POST['blocknumber'])) {
        $lot = $_POST['lotnumber'];
        $block = $_POST['blocknumber'];
        $db = new Database();
        
        $db->duplicate_entries_real_time($lot, $block, "tbl_centralinfo");
        }
    }catch (PDOException $e) {
        throw new Exception("House is already registred!");
    }*/
    header('Content-Type: application/json');
    require_once __DIR__ . '/owner_info_class.php';
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    $owner_info = new OwnerInfo();
    $owner_info->duplicate_email($email);
    $duplicate = $owner->duplicate_email($email);
    echo json_encode((bool)$duplicate);
    

?>