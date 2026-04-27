<?php
    $tb_name = "rent_house";
    $conn = "";
    $config = require 'config.php';
    $attribute_1 = "id";
    $attribute_2 = "lname";
    $attribute_3 = "fname";
    $attribute_4 = "gender";
    $attribute_5 = "age";

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
                $create_table = "CREATE TABLE `$table` (" . implode(', ', $tabledat) . ")";
                $this->pdo->exec($create_table);
        }

        public function insert_table($table, $att_2, $att_3, $att_4, $att_5){
            $insert_info = "INSERT INTO `$table` (`lname`, `fname`, `age`, `gender`) VALUES(:lname, :fname, :age, :gender)";
            $insert_info_query = $pdo->prepare($insert_info);
            $insert_info_query->execute([
            'lname' => $att_2, 
            'fname' => $att_3, 
            'age' => $att_4,
            'gender' => $att5
            ]);
        }





    }
    $lname = trim(($_POST['lname'] ?? null));
    $fname = trim(($_POST['fname'] ?? null));
    $gender = trim(($_POST['gender'] ?? null));
    $age = trim(($_POST['age'] ?? null));
    $owner_info = ["fname" => $fname,
                  "lname" => $lname,
                  "gender" => $gender
                  ];
    $errors = [];
    
    // Check for empty fields; If their is empty field add it to the error list
    foreach ($owner_info as $info => $errorMessage) {
    if (empty(trim($_POST[$info] ?? ''))) {
        $errors[$info] = $errorMessage;
        echo "Error: $errorMessage is required.";
        
    }
    }

    $field = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'lname' => 'VARCHAR(50) NOT NULL',
       'fname' => 'VARCHAR(50) NOT NULL',
       'age' => 'INT(4) NOT NULL',
       'gender' => 'VARCHAR(50) NOT NULL'
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
        echo "Successfully submitted!";
    }


?>