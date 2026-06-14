<?php
session_start();
if (isset($_SESSION['user_id'])) {
   require_once __DIR__ . '/login_class.php';
   $account = new AccountInfo();
   $account->delete_token();

    
}
setcookie("remember_token", "", time() - 3600, "/");
header("Location: login.php");
exit;


?>
