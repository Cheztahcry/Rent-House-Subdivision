<?php

    require_once 'Database.php';
    class SaleInfo extends Database {
        private $query_config;
        private $allowedCentralColumns = ['blocknumber', 'lotnumber', 'house_status', 'user_id'];
        private $allowedSaleColumns = ['houseprice', 'registry_id'];
        public function __construct() {
        parent::__construct();
        $this->query_config = require __DIR__ . '/query_config.php';
    }
        public function create_table_sale($table, array $info_list){
            $this->create_table($table, $info_list);
        }
        public function show_saleinfo(){
            return $this->show_table($this->query_config['tables']['sale']);
        }
        public function account_transactions($user_id){
            $sql = "SELECT * FROM `{$this->query_config['tables']['central']}` WHERE user_id = :user";
            $stmt = $this->pdo->prepare($sql); 
            $stmt->execute([
                'user' => $user_id]); 

            $acc_tran = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $acc_tran;
        }
       public function insert_sale_data(array $central_info, array $sale_info){
        $cleanCentralData = $this->filterData($central_info, $this->allowedCentralColumns);
        $cleanSaleData = $this->filterData($sale_info, $this->allowedSaleColumns);
        try{
            $this->pdo->beginTransaction();
            $this->insert_table($this->query_config['tables']['central'], $cleanCentralData);
            $registry_id = $this->pdo->lastInsertId();
            $cleanSaleData['registry_id'] = $registry_id;
            $this->insert_table($this->query_config['tables']['sale'], $cleanSaleData);
            $this->pdo->commit();
            header("Location: index.php");
        }catch (PDOException $e) {
            $this->pdo->rollBack();
            var_dump("DATABASE CRASHED BECAUSE: " . $e->getMessage());
            if ($e->getCode() == 23000 && strpos($e->getMessage(), '1062') !== false) {
                die("House is already registered");
            }
        } 
       }
       public function innerjoin_table(){
            $sql = "SELECT 
            c.id,
            c.blocknumber,
            c.lotnumber,
            c.house_status,
            s.houseprice
            FROM tbl_centralinfo c
            INNER JOIN tbl_saleinfo s ON s.registry_id = c.id";
            $stmt = $this->pdo->query($sql);
            $sale_records = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $sale_records;
       }

    }
    $lot_number = trim(($_POST['lotnumber'] ?? null));
    $block_number = trim(($_POST['blocknumber'] ?? null));
    $house_price = trim(($_POST['houseprice'] ?? null));
    $house_status = trim(($_POST['house_status'] ?? null));
    

    $sale_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'registry_id' => 'INT NOT NULL',
       'houseprice' => 'DECIMAL(30, 2) NOT NULL',
       'FOREIGN KEY'   => '(registry_id) REFERENCES tbl_centralinfo(id) ON DELETE CASCADE'
    ];
    $central_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'lotnumber' => 'INT NOT NULL',
       'blocknumber' => 'INT NOT NULL',
       'house_status' => 'VARCHAR(20) NOT NULL',
       'user_id' => 'INT NOT NULL',
       'FOREIGN KEY'   => '(user_id) REFERENCES tbl_ownerinfo(id) ON DELETE CASCADE',
       'UNIQUE KEY' => 'unique_property (blocknumber, lotnumber)'
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
        die("Error: You must be logged in to post a product.");
        }
        $expected_fields = [
        'lotnumber'            => 'Block Number is required.',
        'blocknumber'            => 'Lot Number is required.',
        'houseprice'              => 'House Price is required.',
        'house_status'            => 'House Status is required.'
        ];
        
        $errors = [];
        foreach ($expected_fields as $field => $errorMessage) {
        $value = trim($_POST[$field] ?? '');
        
        if ($value === '') {
            $errors[$field] = $errorMessage;
        } else {
            $data_to_submit[$field] = $value;
        }
        }
        if (empty($errors)) {
            $insert_central_info = [ 
                "lotnumber" => $lot_number,
                "blocknumber" => $block_number,
                "house_status" => $house_status,
                "user_id" => $_SESSION['user_id']
                ];
            $insert_sale_info = [ 
                "houseprice" => $house_price,
                "registry_id" => null
                ];

            $sale = new SaleInfo();
            $sale->create_table_sale("tbl_centralinfo", $central_info);
            $sale->create_table_sale("tbl_saleinfo", $sale_info);
            $sale->insert_sale_data($insert_central_info, $insert_sale_info);
            
        }
}

    





?>