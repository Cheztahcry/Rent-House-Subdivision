<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name  = "dbhouserent";
    $tb_name = "rent_house";
    $conn = "";
    $attribute_1 = "id";
    $attribute_2 = "lname";
    $attribute_3 = "fname";
    $attribute_4 = "gender";
    $attribute_5 = "age";


    // Error handling for connection errors
    try {
        $dsn = "mysql:host=$db_host";
    $pdo = new PDO($dsn, $db_user, $db_pass);
    }catch (PDOException $e) {
    error_log($e->getMessage()); 
    die("Internal Server Error. Please try again later."); 
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
    // If there is no errors(User Input) left, create database, table, and insert the data
    if (empty($errors)) {
        echo "Successfully submitted!";
        $create_database = "CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        $use_db = "USE `$db_name`";
        $pdo->exec($create_database);
        $pdo->exec($use_db);
        $create_table = "CREATE TABLE IF NOT EXISTS `$tb_name`(
        `$attribute_1` INT AUTO_INCREMENT PRIMARY KEY,
        `$attribute_2` VARCHAR(50) NOT NULL,
        `$attribute_3` VARCHAR(50) NOT NULL,
        `$attribute_4` VARCHAR(50) NOT NULL,
        `$attribute_5` INT(4) NOT NULL)ENGINE=InnoDB;";
        $pdo->exec($create_table);
        $insert_info = "INSERT INTO `$tb_name` (`lname`, `fname`, `age`, `gender`) VALUES(:lname, :fname, :age, :gender)";
        $insert_info_query = $pdo->prepare($insert_info);
        $insert_info_query->execute([
            'lname' => $lname, 
            'fname' => $fname, 
            'age' => $age,
            'gender' => $gender
            ]);
    }header()
   



?>