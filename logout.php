<?php
session_start();
session_destroy();
setcookie("remember_token", "", time() - 3600, "/");
header("Refresh: 1 ; url=index.php");
exit;


?>
