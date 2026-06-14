<?php
    require_once 'Database.php';
    class AccountInfo extends Database {
        private string $tbl_name = "tbl_ownerinfo";
        public function __construct() {
        parent::__construct();
        
        }
        public function check_credentials($email, $password, $cookie) {
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
                    if (isset($_POST[$cookie])) {
                            $token = bin2hex(random_bytes(32)); 
                            $stored_hash = password_hash($token, PASSWORD_DEFAULT);
                            $expiry = time() + (30 * 24 * 60 * 60);
                            setcookie(
                                "remember_token",   // Name of the cookie
                                $token,             // The raw token value
                                $expiry,            // Expiration timestamp
                                "/",                // Available across your entire website
                                "",                 // Domain (blank for localhost)
                                false,              // Secure: change to true if using HTTPS
                                true                // HttpOnly: Prevents JavaScript/Hackers from reading it!
                            );
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
    $remember_me = trim(($_POST['remember_me'] ?? null));
    $credentials_info = [ 
                "email" => $email,
                "password" => $password,
                "remember_me" => $remember_me
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
        $account->check_credentials($email, $password, $remember_me);
        
    }





?>