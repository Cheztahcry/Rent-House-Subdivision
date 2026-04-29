<?php 
require 'database.php';
$config = require 'config.php';
$owners = new Database(
            $config['host'],
            $config['db'],
            $config['user'],
            $config['password']
        );
$rows = $owners->show_table("rent_house")
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
   
    <img src="css/logo.png" class="logo" alt="Subdivision Logo">
     <h2 style="font-family:Arial, Helvetica, sans-serif;">RHS</h2>
    
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
            <th>Block Number</th>
            <th>Lot Number</th>
            <th>Owner</th>
            <th>Rent Status</th>
            <th>Current Owner</th>
            <th>Rent Prize</th>
    </tr>
    <tbody>
        <?php foreach ($rows as $row): ?>
        
                
                        <tr><td>1</td>
                        <td>1</td>
                        <td><?= $row->fname ?> <?= $row->lname?></td>
                        <td>For Rent</td>
                        <td><?= $row->fname ?> <?= $row->lname?></td>
                        <td>₱12,500</td>
                        </tr>
                
        <?php endforeach; ?>
        </tbody>
        </table>
</body>
</html>

