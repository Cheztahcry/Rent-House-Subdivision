<?php
    require_once 'Database.php';
    class AccountInfo extends Database {
        private string $tbl_name = "tbl_ownerinfo";
        public function __construct() {
        parent::__construct();
        
        }
        public function check_credentials($email, $password) {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE email = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            if ($user) {
                if (password_verify($password, $user->password_hash)) {
                    
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                        session_regenerate_id();
                    }
                    
                    $_SESSION["user_id"] = $user->id;
                    echo "Log-in Successful. Redirecting...";
                    header("Refresh: 1; url=index.php");
                    exit;
                    
                } else {
                    die("Wrong email or password.");

                }
            } else {
                die("Account doesn't exist"); 
            }
        }   
    }
}




    $email = trim(($_POST['email'] ?? null));
    $password = trim(($_POST['password'] ?? null));
    $credentials_info = [ 
                "email" => $email,
                "password" => $password
                  ];
    $errors = [];
    
    // Check for empty fields; If their is empty field add it to the error list
    /*foreach ($credentials_info as $info => $errorMessage) {
    if (empty(trim($_POST[$info] ?? ''))) {
        $errors[$info] = $errorMessage;
        echo $errorMessage;
        
    }
    }*/

    if (empty($errors)) {
        $account = new AccountInfo();
        $account->check_credentials($email, $password);
        
    }





?>