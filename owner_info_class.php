<?php
    header('Content-Type: application/json');
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
        public function user_token(array $create_token){
            
            $this->create_table("tbl_usertoken", $create_token);
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
        public function duplicate_email($email){
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE  email = :email" ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $email]);
            $results = $stmt->fetchColumn();
            if ($results > 0){
                return true;
            }
            else{
                return false;
            }
       }
       public function generate_user_id() {
            // Generate 16 bytes of random data
            $data = random_bytes(16);

            // Set version to 0100 (version 4)
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
            // Set bits 6-7 to 10
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

            // Format the string into the standard 8-4-4-4-12 UUID layout
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
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
    $owner = new OwnerInfo();
    $user_id = $owner->generate_user_id();
    
    $expected_fields = [
    'fname'            => 'First name is required.',
    'lname'            => 'Last name is required.',
    'age'              => 'Age is required.',
    'gender'           => 'Gender is required.',
    'email'            => 'Email is required.',
    'password'         => 'Password is required.',
    'confirm_password' => 'Please confirm your password.'
    ];
    $user_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'user_uid' => 'VARCHAR (255) NOT NULL',
       'lname' => 'VARCHAR(50) NOT NULL',
       'fname' => 'VARCHAR(50) NOT NULL',
       'age' => 'INT NOT NULL',
       'gender' => 'VARCHAR(20) NOT NULL',
       'email' => 'VARCHAR(50) NOT NULL UNIQUE',
        'password_hash' => 'VARCHAR(255) NOT NULL ',
        'picture' => 'VARCHAR(255) NULL',
        ];
    $token_info = [
       'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
       'user_id' => 'INT NOT NULL',
       'token_hash' => 'VARCHAR(255) NOT NULL',
       'expiry' => 'DATETIME NOT NULL',
       'FOREIGN KEY'   => '(user_id) REFERENCES tbl_ownerinfo(id) ON DELETE CASCADE'
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
                "password_hash" => $password_hash,
                "user_uid" => $user_id

                  ];  
        $owner = new OwnerInfo();
        $owner->owner_table($user_info);
        $owner->user_token($token_info);
        
    }
    $duplicate = $owner->duplicate_email($email);
    echo json_encode((bool)$duplicate);

    





?>