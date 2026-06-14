<?php

require_once __DIR__ .'/rent_info_class.php';
require_once __DIR__ .'/sale_info_class.php';

if (isset($_POST['lotnumber']) && isset($_POST['blocknumber'])) {
    $lot = $_POST['lotnumber'];
    $block = $_POST['blocknumber'];
    $rent_info = new RentInfo();
    $rent_info->duplicate_entries_real_time($lot, $block);
    $rent_info = new SaleInfo();
    $rent_info->duplicate_entries_real_time($lot, $block);
}

?>