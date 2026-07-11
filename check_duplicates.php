<?php
    
    require_once __DIR__ .'/database.php';


    try{
        if (isset($_POST['lotnumber']) && isset($_POST['blocknumber'])) {
        $lot = $_POST['lotnumber'];
        $block = $_POST['blocknumber'];
        $db = new Database();
        
        $db->duplicate_entries_real_time($lot, $block, "tbl_centralinfo");
        }
    }catch (PDOException $e) {
        throw new Exception("House is already registred!");
    }

?>