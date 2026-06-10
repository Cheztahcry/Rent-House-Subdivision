<?php
    require_once 'Database.php';
    class OwnerInfo extends Database {
        private string $tbl_name = "tbl_ownerinfo";
        private array $info_list;
        public function __construct() {
        parent::__construct();
        $this->info_list = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'lname' => 'VARCHAR(50) NOT NULL',
       'fname' => 'VARCHAR(50) NOT NULL',
       'age' => 'INT NOT NULL',
       'gender' => 'VARCHAR(20) NOT NULL',
       'email' => 'VARCHAR(50) NOT NULL UNIQUE',
       'password_hash' => 'VARCHAR(255) NOT NULL '
        ];
    }
        public function owner_table(){
            
            $this->create_table($this->tbl_name, $this->info_list);
        }
        public function insert_owner_info(array $info_list){
            
            $this->insert_table($this->tbl_name, $info_list);
        }
        public function show_ownerinfo($id) {
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);          
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user;
        }

    }
    $lname = trim(($_POST['lname'] ?? null));
    $fname = trim(($_POST['fname'] ?? null));
    $gender = trim(($_POST['gender'] ?? null));
    $age = trim(($_POST['age'] ?? null));
    $email = trim(($_POST['email'] ?? null));
    $password = trim(($_POST['password'] ?? null));
    $confirm_password = trim(($_POST['confirm_password'] ?? null));
    $required_pass = 8;
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $insert_info = [ 
                "fname" => $fname,
                "lname" => $lname,
                "age" => $age,
                "gender" => $gender,
                "email" => $email,
                "password_hash" => $password_hash
                  ];
    $errors = [];
    
    // Check for empty fields; If their is empty field add it to the error list
    /*foreach ($insert_info as $info => $errorMessage) {
    if (empty(trim($_POST[$info] ?? ''))) {
        $errors[$info] = $errorMessage;
        
    }
    }*/
    if(!isset($_SESSION["user_id"])){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        die("Email is invalid");
    }
    else if(strlen($password < $required_pass)){
        die("Password must be at least 8 characters ");
    }
    else if(! preg_match("/[a-z]/i", $password)){
        die("Password must contain atleast one letter");
    }
    else if(! preg_match("/[0-9]/", $password)){
        die("Password must contain atleast one number");
    }
    else if($password !== $confirm_password){
        die("Passwords must match");
    }
    else {
        
        $rent = new OwnerInfo();
        $rent->owner_table();
        $rent->insert_owner_info($insert_info);
        echo "Submit Successful";
        header("Refresh: 5; url=index.php");
        exit;
    }
    }

    





?>