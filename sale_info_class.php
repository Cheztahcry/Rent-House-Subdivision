<?php

    require_once 'Database.php';
    class SaleInfo extends Database {
        private string $tbl_name = "tbl_saleinfo";
        public function __construct() {
        parent::__construct();
    }
        public function sale_table(array $info_list){
            
            $this->create_table($this->tbl_name, $info_list);
        }
        public function insert_sale_info(array $info_list){
            
            $this->insert_table($this->tbl_name, $info_list);
        }
        public function show_rentinfo(){
            return $this->show_table($this->tbl_name);
        }

    }
    $lot_number = trim(($_POST['lotnumber'] ?? null));
    $block_number = trim(($_POST['blocknumber'] ?? null));
    $house_price = trim(($_POST['houseprice'] ?? null));
    $house_status = trim(($_POST['house_status'] ?? null));

    $insert_info = [ 
                "lotnumber" => $lot_number,
                "blocknumber" => $block_number,
                "houseprice" => $house_price,
                "house_status" => $house_status
                  ];
    $create_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'lotnumber' => 'INT NOT NULL',
       'blocknumber' => 'INT NOT NULL',
       'houseprice' => 'DECIMAL(30, 2) NOT NULL',
       'house_status' => 'VARCHAR(20) NOT NULL'
    ];
    $errors = [];

    
    foreach ($insert_info as $info => $errorMessage) {
    if (empty(trim($_POST[$info] ?? ''))) {
        $errors[$info] = $errorMessage;
        
    }
    }

    if (empty($errors)) {
        $sale = new SaleInfo();
        $sale->sale_table($create_info);
        $sale->insert_sale_info($insert_info);
        echo "Submit Successful";
        header("Refresh: 1; url=index.php");
        exit;
    }

    





?>