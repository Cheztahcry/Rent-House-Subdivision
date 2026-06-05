<?php
session_start();
$show_sale = false;
$show_rent = true;
$rows = null;
if ($show_sale == true){
    include_once __DIR__ . '/sale_info_class.php';
    if (class_exists('SaleInfo')){
    $sale = new SaleInfo();
    $rows = $sale->show_saleinfo();
    }
}
if ($show_rent == true){
    include_once __DIR__ . '/rent_info_class.php';
    if (class_exists('RentInfo')){
    $rent = new RentInfo();
    $rows = $rent->show_rentinfo();
    }
}


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
<body>
<header>
    <div class="logo_row">
        <img src="assets/img/logo.png" class="logo" alt="Subdivision Logo">
        <a href="index.php" class="brand-title">RHS</a>
    </div>
    <div class="header-links">
        <?php if($user):?>
            <span class="user_greet">HELLO, <?= htmlspecialchars($user->fname) ?></span>
            <div class="action-group">
                <a href="house_info.php" class="signin-btn">REGISTER MY HOUSE</a>
                <a href="logout.php" class="signin-btn">LOG OUT</a>
            </div>
        <?php else:?>
            <div class="action-group">
                <a href="login.php" class="signin-btn">REGISTER MY HOUSE</a>
                <a href="login.php" class="signin-btn">LOG IN</a>
                <a href="owner_info.php" class="signin-btn">REGISTER</a>
            </div>
        <?php endif;?>
    </div>
</header>
    <div>
        <input type="text" name="search_bar" id="search_bar"><button> Search </button><button> Filter </button>
        <select name="cars" id="cars">
        <option value="volvo">Block</option>
        <option value="saab">Lot</option>
        <option value="mercedes">House Status</option>
        </select>
        <select name="cars" id="cars">
        <option value="volvo">Ascending</option>
        <option value="saab">Descending</option>
        </select>
    </div>

    <button> For Sell </button>
    <button> For Rent </button>
    
        <div class = "dashboard-container">
        
        <table>
        <thead>
        <tr>
            <th>House ID</th>
            <th>Block Number</th>
            <th>Lot Number</th>
            <th>Status</th>
            <?php if ($show_sale): ?>
            <th>Price</th>
            <?php elseif ($show_rent): ?>
            <th>Rent</th>
            <th>Down Payment</th>

    </tr>
    <tbody>
        <?php if ($rows && count($rows) > 0): ?>
        <?php foreach ($rows as $row): ?>
        
                
                        <tr>
                        <td><?= $row->id ?></td>
                        <td><?= $row->blocknumber ?></td>
                        <td><?= $row->lotnumber ?></td>
                        <td><?= $row->house_status ?></td>
                        <?php if ($show_sale): ?>
                        <td><?= $row->houseprice ?></td>
                        <?php elseif ($show_rent): ?>
                        <td><?= $row->rentprice ?></td>
                        <td><?= $row->downpayment ?></td>
                        <td><button> Inquire </button>
                        <button> Contact Seller </button>
                        <button> Bookmark </button>
                        </tr>
        <?php endif; ?>        
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                    <strong>No properties are currently available.</strong><br>
                    Please try refreshing the page or check back later.
                </td>
            </tr>
        <?php endif; ?>
        <?php endif; ?>
        </tbody>
        </table>
        
</body>
</div>
 <footer>
        <p>© 2026 RHS by C.J.C. All rights reserved.</p>
    </footer>
</body>
</html>