<?php
    require_once 'Database.php';
   
    class RentInfo extends Database {
        private $allowedCentralColumns = ['blocknumber', 'lotnumber', 'house_status', 'user_id'];
        private $allowedRentColumns = ['rentprice', 'downpayment', 'registry_id'];
        private $query_config;
        
        public function __construct() {
        parent::__construct();
        $this->query_config = require __DIR__ . '/query_config.php';
        
    }
        public function create_table_rent($table, array $info_list){
            $this->create_table($table, $info_list);
        }
        public function show_rentinfo(){
            try {
                return $this->show_table($this->query_config['tables']['rent']);
            }catch (PDOException $e) {
                die("No Data to Show. Please Restart");
            } 
            
        }
        public function account_transactions($user_id){
            $sql = "SELECT * FROM `{$this->query_config['tables']['central']}` WHERE user_id = :user";
            $stmt = $this->pdo->prepare($sql); 
            $stmt->execute([
                'user' => $user_id]); 

            $acc_tran = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $acc_tran;
        }
        
       public function insert_rent_data(array $central_info, array $rent_info){
        $cleanCentralData = $this->filterData($central_info, $this->allowedCentralColumns);
        $cleanRentData = $this->filterData($rent_info, $this->allowedRentColumns);
        try{
            $this->pdo->beginTransaction();
            $this->insert_table($this->query_config['tables']['central'], $cleanCentralData);
            $registry_id = $this->pdo->lastInsertId();
            $cleanRentData['registry_id'] = $registry_id;
            $this->insert_table($this->query_config['tables']['rent'], $cleanRentData);
            $this->pdo->commit();
            header("Location: index.php");
        }catch (PDOException $e) {
            $this->pdo->rollBack();
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
            r.rentprice,  
            r.downpayment
            FROM tbl_centralinfo c
            INNER JOIN tbl_rent_info r ON r.registry_id = c.id";
            $stmt = $this->pdo->query($sql);
            $rent_records = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $rent_records;
       }
       public function innerjoin_table_dashboard($user_id){
            $sql = "SELECT 
            c.id,
            c.blocknumber,
            c.lotnumber,
            c.house_status,
            r.rentprice,  
            r.downpayment
            FROM tbl_centralinfo c
            INNER JOIN tbl_rent_info r ON r.registry_id = c.id
            WHERE c.user_id = :user;";
            $stmt = $this->pdo->prepare($sql); 
            $stmt->execute([
                'user' => $user_id]); 
            $rent_records = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $rent_records;
       }
       
    

    }
    
    $lot_number = trim(($_POST['lotnumber'] ?? null));
    $block_number = trim(($_POST['blocknumber'] ?? null));
    $house_status = trim(($_POST['house_status'] ?? null));
    $rent_price = trim(($_POST['rentprice'] ?? null));
    $down_payment = trim(($_POST['downpayment'] ?? null));
    
    

    
    $rent_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'registry_id' => 'INT NOT NULL',
       'rentprice' => 'DECIMAL(10, 2) NOT NULL',
       'downpayment' => 'DECIMAL(10,2) NOT NULL',
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
    $bookmark_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'registry_id' => 'INT NOT NULL',
       'user_id' => 'INT NOT NULL',
       'FOREIGN KEY'   => '(user_id) REFERENCES tbl_ownerinfo(id) ON DELETE CASCADE',
       'FOREIGN KEY'   => '(registry_id) REFERENCES tbl_centralinfo(id) ON DELETE CASCADE',
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
        'rentprice'              => 'Rent Price is required.',
        'downpayment'           => 'Down Payment is required.',
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
            $insert_rent_info = [ 
                "rentprice" => $rent_price,
                "registry_id" => null,
                "downpayment" => $down_payment
                ];
            $rent = new RentInfo();
            $rent->create_table_rent("tbl_centralinfo", $central_info);
            $rent->create_table_rent("tbl_rent_info", $rent_info);
            $rent->create_table_rent("tbl_bookmark", $bookmark_info);
            
            $rent->insert_rent_data($insert_central_info, $insert_rent_info);
            
        }
}

    





?>