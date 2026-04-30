<?php 
include 'database.php';
$config = require 'config.php';
$owners = new Database(
            $config['host'],
            $config['db'],
            $config['user'],
            $config['password']
        );
$rows = $owners->show_table($tb_name)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
    
</head>
<header>
   
    <img src="assets/img/logo.png" class="logo" alt="Subdivision Logo">
     <h2 style="font-family:Arial, Helvetica, sans-serif;">RHS</h2>
    <a href="register_2.php" class="signin-btn">Sign in</a>
    
</header>
<html>
    <footer>
<img src="css/logo.png" class="logo" alt="Subdivision Logo">
</footer>
</html>
<body>
    <div class = "dashboard-container">
        
        <table>
        <thead>
        <tr>
            <th>Owner ID</th>
            <th>Block Number</th>
            <th>Lot Number</th>
            <th>Owner</th>
            <th>Rent Status</th>
            <th>Current Owner</th>
            <th>Rent Prize</th>
            <th>Down Payment</th>
    </tr>
    <tbody>
        <?php foreach ($rows as $row): ?>
        
                
                        <tr>
                        <td><?= $row->id ?></td>
                        <td><?= $row->blocknumber ?></td>
                        <td><?= $row->lotnumber ?></td>
                        <td><?= $row->fname ?> <?= $row->lname?></td>
                        <td>For Rent</td>
                        <td><?= $row->fname ?> <?= $row->lname?></td>
                        <td><?= $row->rentprice ?></td>
                        <td><?= $row->downpayment?></td>
                        </tr>
                
        <?php endforeach; ?>
        </tbody>
        </table>
</body>
</html>

