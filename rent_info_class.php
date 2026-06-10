<?php

    require_once 'Database.php';
    class RentInfo extends Database {
        private string $tbl_name = "tbl_rentinfo";
        public function __construct() {
        parent::__construct();
    }
        public function rent_table(array $info_list){
            
            $this->create_table($this->tbl_name, $info_list);
        }
        public function insert_rent_info(array $info_list){
            
            $this->insert_table($this->tbl_name, $info_list);
        }
        public function show_rentinfo(){
            try {
                return $this->show_table($this->tbl_name);
            }catch (PDOException $e) {
                die("No Data to Show. Please Restart");
            } 
            
        }

    }
    $lot_number = trim(($_POST['lotnumber'] ?? null));
    $block_number = trim(($_POST['blocknumber'] ?? null));
    $rent_price = trim(($_POST['rentprice'] ?? null));
    $down_payment = trim(($_POST['downpayment'] ?? null));
    $house_status = trim(($_POST['house_status'] ?? null));

    $insert_info = [ 
                "lotnumber" => $lot_number,
                "blocknumber" => $block_number,
                "rentprice" => $rent_price,
                "downpayment" => $down_payment,
                "house_status" => $house_status
                  ];
    $create_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'lotnumber' => 'INT NOT NULL',
       'blocknumber' => 'INT NOT NULL',
       'rentprice' => 'DECIMAL(10, 2) NOT NULL',
       'downpayment' => 'DECIMAL(10,2) NOT NULL',
       'house_status' => 'VARCHAR(20) NOT NULL'
    ];
    $errors = [];

    
    foreach ($insert_info as $info => $errorMessage) {
    // Clean up the input safely
    $value = trim($_POST[$info] ?? '');
    
    // FIX: Check if the string length is 0. This allows '0' or 0 to be valid.
    if ($value === '') {
        $errors[$info] = $errorMessage;
        
        // Log or handle the specific missing field safely
        // (Optional: You can just use $errorMessage here instead of hardcoding echoes)
        return($_POST[$info] ?? "$info is missing/empty<br>");
    }
}

    if (empty($errors)) {
        $rent = new RentInfo();
        $rent->rent_table($create_info);
        $rent->insert_rent_info($insert_info);
        echo("Submit Successful");
        header("Location: index.php");
        exit;
    }

    





?>