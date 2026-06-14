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
        public function insert_sale_info(array $insert_info){
            $this->insert_table($this->tbl_name, $insert_info);
        }
        public function show_saleinfo(){
            return $this->show_table($this->tbl_name);
        }
        public function account_transactions($user_id){
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE user_id = :user";
            $stmt = $this->pdo->prepare($sql); 
            $stmt->execute([
                'user' => $user_id]); 

            $acc_tran = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $acc_tran;
        }
        public function duplicate_entries_real_time($lot, $block, ){
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE  lotnumber = :lot AND blocknumber = :blocknumber" ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'lot' => $lot,
                'blocknumber' => $block]);
            $results = $stmt->fetchColumn();
            if ($results > 0){
                echo "House is already registered";
            }
       }
       public function duplicate_entries_submit($lot, $block, array $insert_info){
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE  lotnumber = :lot AND blocknumber = :blocknumber" ;
            $stmt = $this->pdo->prepare($sql);
             $stmt->execute([
                'lot' => $lot,
                'blocknumber' => $block]);
            $results = $stmt->fetchColumn();
            if ($results > 0){
                echo "House is already registered";
            }
            else{
                $this->insert_sale_info($insert_info);
                echo("Submit Successful");
                header("Location: index.php");
                exit;
            }
       }

    }
    $lot_number = trim(($_POST['lotnumber'] ?? null));
    $block_number = trim(($_POST['blocknumber'] ?? null));
    $house_price = trim(($_POST['houseprice'] ?? null));
    $house_status = trim(($_POST['house_status'] ?? null));
    

    $create_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'lotnumber' => 'INT NOT NULL',
       'blocknumber' => 'INT NOT NULL',
       'houseprice' => 'DECIMAL(30, 2) NOT NULL',
       'house_status' => 'VARCHAR(20) NOT NULL',
       'user_id' => 'INT NOT NULL',
       'FOREIGN KEY'   => '(user_id) REFERENCES tbl_ownerinfo(id) ON DELETE CASCADE'
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
            $insert_info = [ 
                "lotnumber" => $lot_number,
                "blocknumber" => $block_number,
                "houseprice" => $house_price,
                "house_status" => $house_status,
                "user_id" => $_SESSION['user_id']
                ];

            $sale = new SaleInfo();
            $sale->sale_table($create_info);
            $sale->duplicate_entries_submit($lot_number, $block_number, $insert_info);
            
        }
}

    





?>