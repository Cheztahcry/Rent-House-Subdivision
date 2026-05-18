<?php
session_start();
include_once 'rent_info_class.php';
$rent = new RentInfo();
$rows = $rent->show_rentinfo();
$user = false;
if(isset($_SESSION["user_id"])){
    include_once  'owner_info_class.php';
    $owner = new OwnerInfo();
    $user = $owner->show_ownerinfo($_SESSION["user_id"]);
    


}
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

    <a href="index.php" class="signin-btn">RHS</a>
    <a href="rent_info.php" class="signin-btn">REGISTER MY HOUSE</a>

    <?php if($user):?>
        <p> Hello <?= htmlspecialchars($user->fname) ?></p>
        <a href="logout.php" class="signin-btn">LOG-OUT</a>
    <?php else:?>
        <a href="login.php" class="signin-btn">LOG-IN</a>
        <a href="owner_info.php" class="signin-btn">Register</a>
    <?php endif;?>
    
</header>
<html>
    <footer>
<img src="assets/img/logo.png" class="logo" alt="Subdivision Logo">
</footer>
</html>
<body>
    <div class = "dashboard-container">
        
        <table>
        <thead>
        <tr>
            <th>House ID</th>
            <th>Block Number</th>
            <th>Lot Number</th>
            <th>Rent Status</th>
            <th>Rent Prize</th>
            <th>Down Payment</th>

    </tr>
    <tbody>
        <?php if ($rows): ?>
        <?php foreach ($rows as $row): ?>
        
                
                        <tr>
                        <td><?= $row->id ?></td>
                        <td><?= $row->blocknumber ?></td>
                        <td><?= $row->lotnumber ?></td>
                        <td>For Rent</td>
                        <td><?= $row->rentprice ?></td>
                        <td><?= $row->downpayment?></td>
                        </tr>
                
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
        </table>
        
</body>
</html>

