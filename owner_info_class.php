<?php
    require_once 'Database.php';
    class OwnerInfo extends Database {
        private string $tbl_name = "tbl_ownerinfo";
        private array $info_list;
        public function __construct() {
        parent::__construct();
    }
        public function owner_table(array $create_info){
            
            $this->create_table($this->tbl_name, $create_info);
        }
        private function insert_owner_info(array $insert_info){
            $this->insert_table($this->tbl_name, $insert_info);
        }
        public function show_ownerinfo($id) {
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);          
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user;
        }

        public function update_owner(int $id, array $updates){
            if (empty($updates)) return false;
            $sets = [];
            $params = [];
            foreach ($updates as $col => $val) {
                $sets[] = "`$col` = :$col";
                $params[":$col"] = $val;
            }
            $params[':id'] = $id;
            $sql = "UPDATE `{$this->tbl_name}` SET " . implode(', ', $sets) . " WHERE `id` = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        }
        public function duplicate_email_real_time($email){
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE  email = :email" ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $email]);
            $results = $stmt->fetchColumn();
            if ($results > 0){
                echo "Email is already registered";
            }
       }
       public function duplicate_email_submit($email, array $insert_info){
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE  email = :email" ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $email]);
            $results = $stmt->fetchColumn();
            if ($results > 0){
                echo "Email is already registered";
            }
            else{
                $this->insert_owner_info($insert_info);
                echo("Submit Successful");
                header("Location: index.php");
                exit;
            }
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
    
    $expected_fields = [
    'fname'            => 'First name is required.',
    'lname'            => 'Last name is required.',
    'age'              => 'Age is required.',
    'gender'           => 'Gender is required.',
    'email'            => 'Email is required.',
    'password'         => 'Password is required.',
    'confirm_password' => 'Please confirm your password.'
    ];
    $create_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'lname' => 'VARCHAR(50) NOT NULL',
       'fname' => 'VARCHAR(50) NOT NULL',
       'age' => 'INT NOT NULL',
       'gender' => 'VARCHAR(20) NOT NULL',
       'email' => 'VARCHAR(50) NOT NULL UNIQUE',
        'password_hash' => 'VARCHAR(255) NOT NULL ',
        'picture' => 'VARCHAR(255) NULL'
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
    
    if (!isset($errors['password']) && !isset($errors['confirm_password'])) {
    if ($data_to_submit['password'] !== $data_to_submit['confirm_password']) {
        $errors['password_match'] = "Your passwords do not match!";
    }
    }

    

    if (empty($errors)) {
        $insert_info = [ 
                "fname" => $fname,
                "lname" => $lname,
                "age" => $age,
                "gender" => $gender,
                "email" => $email,
                "password_hash" => $password_hash
                  ];  
        $owner = new OwnerInfo();
        $owner->owner_table($create_info);
        $owner->duplicate_email_submit($email, $insert_info);
    }

    





?>