<?php
// 1. Include your class file
require_once 'rent_info_class.php';
require_once __DIR__ . '/sale_info_class.php';

// 2. Check if JavaScript sent the data
if (isset($_POST['lotnumber']) && isset($_POST['blocknumber'])) {
    $lot = $_POST['lotnumber'];
    $block = $_POST['blocknumber'];
    $rentInfo = new RentInfo();
    $rentInfo->duplicate_entries_real_time($lot, $block);
}
?>