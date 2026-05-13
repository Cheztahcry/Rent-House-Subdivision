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
            return $this->show_table($this->tbl_name);
        }

    }
    $lot_number = trim(($_POST['lotnumber'] ?? null));
    $block_number = trim(($_POST['blocknumber'] ?? null));
    $rent_price = trim(($_POST['rentprice'] ?? null));
    $down_payment = trim(($_POST['downpayment'] ?? null));
    $insert_info = [ 
                "lotnumber" => $lot_number,
                "blocknumber" => $block_number,
                "rentprice" => $rent_price,
                "downpayment" => $down_payment 
                  ];
    $create_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'lotnumber' => 'INT NOT NULL',
       'blocknumber' => 'INT NOT NULL',
       'rentprice' => 'DECIMAL(10, 2) NOT NULL',
       'downpayment' => 'DECIMAL(10,2) NOT NULL'
    ];
    $errors = [];
    
    // Check for empty fields; If their is empty field add it to the error list
    foreach ($insert_info as $info => $errorMessage) {
    if (empty(trim($_POST[$info] ?? ''))) {
        $errors[$info] = $errorMessage;
        
    }
    }

    if (empty($errors)) {
        $rent = new RentInfo();
        $rent->rent_table($create_info);
        $rent->insert_rent_info($insert_info);
        echo "Submit Successful";
        header("Refresh: 5; url=index.php");
        exit;
    }

    





?>