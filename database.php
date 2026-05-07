<?php
    $tb_name = "rent_house";
    $conn = "";
    $config = require 'config.php';

    class DataBase{
        private $pdo;
        public function __construct(
            private string $host,
            private string $dbname,
            private string $user,
            private string $password
              
        ){
            $dsn = "mysql:host=$this->host";
            $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                $this->pdo = new PDO($dsn, $this->user, $this->password);
                $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `{$this->dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $this->pdo->exec("USE `{$this->dbname}` ");
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());

            }
        }
        public function create_table($table, array $column){
            $tabledat = [];
            foreach($column as $name => $data_type){
                $tabledat[] = "`$name` $data_type";
            }
                $create_table = "CREATE TABLE IF NOT EXISTS `$table` (" . implode(', ', $tabledat) . ")";
                $this->pdo->exec($create_table);
                $add_column = "ALTER TABLE `$table` ADD COLUMN IF NOT EXISTS (" . implode(', ', $tabledat) . ")";
                $this->pdo->exec($add_column);
        }


        public function show_table($table){
            $show = "SELECT * FROM `$table`";
            $show_query = $this->pdo->query($show);
            return $show_query->fetchAll(PDO::FETCH_OBJ);
        }

        public function insert_table($table, array $column){
            unset($column['id']);
            $attributes = array_keys($column);
            $imp_att = implode(", ", $attributes);
            $place_att = ":". implode(", :", $attributes);
            $insert_info = "INSERT INTO `$table` ($imp_att) VALUES($place_att)";
            try {
                $insert = $this->pdo->prepare($insert_info);
                return $insert->execute($column);
                } 
            catch (PDOException $e) {
                die("Insert Error: " . $e->getMessage());
                }
        }





    }
    $lname = trim(($_POST['lname'] ?? null));
    $fname = trim(($_POST['fname'] ?? null));
    $gender = trim(($_POST['gender'] ?? null));
    $age = trim(($_POST['age'] ?? null));
    $lot_number = trim(($_POST['lotnumber'] ?? null));
    $block_number = trim(($_POST['blocknumber'] ?? null));
    $rent_price = trim(($_POST['rentprice'] ?? null));
    $down_payment = trim(($_POST['downpayment'] ?? null));
    $contact_number = trim(($_POST['contactnumber'] ?? null));
    $owner_info = ["fname" => $fname,
                  "lname" => $lname,
                  "age" => $age,
                  "gender" => $gender,
                  "lotnumber" => $lot_number,
                  "blocknumber" => $block_number,
                  "rentprice" => $rent_price,
                  "downpayment" => $down_payment,
                  "contactnumber" => $contact_number
                  ];
    $errors = [];
    
    // Check for empty fields; If their is empty field add it to the error list
    foreach ($owner_info as $info => $errorMessage) {
    if (empty(trim($_POST[$info] ?? ''))) {
        $errors[$info] = $errorMessage;
        
    }
    }

    $field = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'lname' => 'VARCHAR(50) NOT NULL',
       'fname' => 'VARCHAR(50) NOT NULL',
       'age' => 'INT NOT NULL',
       'gender' => 'VARCHAR(20) NOT NULL',
       'lotnumber' => 'INT NOT NULL',
       'blocknumber' => 'INT NOT NULL',
       'rentprice' => 'DECIMAL(10, 2) NOT NULL',
       'downpayment' => 'DECIMAL(10,2) NOT NULL',
       'contactnumber' => 'INT(4) NOT NULL'
    ];

    // If there is no errors(User Input) left, create database, table, and insert the data
    if (empty($errors)) {
        $database = new Database(
            $config['host'],
            $config['db'],
            $config['user'],
            $config['password']
        );
        $database->create_table($tb_name, $field);
        $database->insert_table($tb_name, $owner_info);
        $rows = $database->show_table($tb_name);
        echo "Submit Successful";
        header("Refresh: 5; url=index.php");
        exit;
    }

        

        



?>