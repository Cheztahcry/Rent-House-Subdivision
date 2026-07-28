<?php
    require_once 'Database.php';
    class AccountInfo extends Database {
        private string $tbl_name = "tbl_ownerinfo";
        private string $tbl_token = "tbl_usertoken";
        public function __construct() {
        parent::__construct();
        
        }
        public function delete_token(){
            $sql = "DELETE FROM tbl_usertoken WHERE user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$_SESSION['user_id']]);
            $_SESSION = array();
            session_destroy();
        }
        public function fetch_token(){
            $cookie_token = $_COOKIE['remember_token'];
            $sql = "SELECT user_id, token_hash FROM tbl_usertoken";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $saved_tokens = $stmt->fetchAll(PDO::FETCH_OBJ);

            foreach ($saved_tokens as $row) {
                if (password_verify($cookie_token, $row->token_hash)) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $row->user_id;
                    break; 
                }
            }
        }
        
        public function check_credentials($email, $password, $cookie) {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $sql = "SELECT * FROM `{$this->tbl_name}` WHERE email  = ? LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            if ($user) {
                if (password_verify($password, $user->password_hash)) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                        session_regenerate_id();
                    }
                    if ($cookie) {
                            $token = bin2hex(random_bytes(32)); 
                            $stored_hash = password_hash($token, PASSWORD_DEFAULT);
                            $expiry = time() + (30 * 24 * 60 * 60);
                            $expiry_date = date('Y-m-d H:i:s', $expiry);
                            $insert_info = [ 
                                "user_id" => $user->id,
                                "token_hash" => $stored_hash,
                                "expiry" => $expiry_date
                            ];
                            $this->insert_table($this->tbl_token, $insert_info);
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
                    return true;

                    
                } else {
                    return false;

                }
            } else {
                return false; 
            }
        }
        else{
            return false;
        }   
    }

}   
    // Check for empty fields; If there is empty field add it to the error list
    /*foreach ($credentials_info as $info => $errorMessage) {
    if (empty(trim($_POST[$info] ?? ''))) {
        $errors[$info] = $errorMessage;
        echo $errorMessage;
        
    }
    }*/





?>