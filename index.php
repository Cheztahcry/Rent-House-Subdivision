<?php
session_start();
$show_sale = false;
$show_rent = true;
$rent_rows = null;
$sale_rows = null;
if ($show_sale == true){
    include_once __DIR__ . '/sale_info_class.php';
    if (class_exists('SaleInfo')){
    $sale = new SaleInfo();
    $sale_rows = $sale->show_saleinfo();
    }
}
if ($show_rent == true){
    include_once __DIR__ . '/rent_info_class.php';
    if (class_exists('RentInfo')){
    $rent = new RentInfo();
    $rent_rows = $rent->show_rentinfo();
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
    <div class = "options">
        <div class="status-toggle">
            <label class="status-option">
                <input type="radio" name="property_status" value="sale" checked>
                <span>For Sale</span>
            </label>
            <label class="status-option">
                <input type="radio" name="property_status" value="rent">
                <span>For Rent</span>
            </label>
        </div>

        <div class="search-field">
            <span class="search-icon" aria-hidden="true"></span>
            <input type="text" name="search_bar" id="search_bar" class="search-input" placeholder="Search by location, block, or ID...">
        </div>
        <button type="button" class="option-btn search-btn">Search</button>
        <button type="button" class="option-btn filter-btn">Filter</button>
        <div class="filter-group">
            <label class="visually-hidden" for="sort_by">Sort by</label>
            <select name="sort_by" id="sort_by" class="filter-select">
                <option value="block">Block Number</option>
                <option value="lot">Lot Number</option>
            </select>
            <label class="visually-hidden" for="sort_order">Sort order</label>
            <select name="sort_order" id="sort_order" class="filter-select">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
    </div>

        
    <div class = "sale-dashboard" id = "sale-dashboard">
        <div class = "dashboard-container">
        
            <table>
            <thead>
            <tr>
                <th>House ID</th>
                <th>Block Number</th>
                <th>Lot Number</th>
                <th>Status</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php if ($sale_rows && count($sale_rows) > 0): ?>
                <?php foreach ($sale_rows as $row): ?>             
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= $row->blocknumber ?></td>
                    <td><?= $row->lotnumber ?></td>
                    <td><?= $row->house_status ?></td>
                    <td><?= $row->houseprice ?></td>
                    <td class="action-cell">
                        <button type="button" class="action-btn inquire-btn">Inquire</button>
                        <button type="button" class="action-btn contact-btn">Contact Seller</button>
                        <button type="button" class="action-btn bookmark-btn"><span class="btn-icon" aria-hidden="true">♥</span> Bookmark</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                            <strong>No properties are currently available.</strong><br>
                            Please try refreshing the page or check back later.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
                </table>
        </div>
        
    </div>
    <div class = "rent-dashboard" id = "rent-dashboard">
        <div class = "dashboard-container">
        
            <table>
            <thead>
            <tr>
                <th>House ID</th>
                <th>Block Number</th>
                <th>Lot Number</th>
                <th>Status</th>
                <th>Rent</th>
                <th>Down Payment</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php if ($rent_rows && count($rent_rows) > 0): ?>
                <?php foreach ($rent_rows as $row): ?>
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= $row->blocknumber ?></td>
                    <td><?= $row->lotnumber ?></td>
                    <td><?= $row->house_status ?></td>
                    <td><?= $row->rentprice ?></td>
                    <td><?= $row->downpayment ?></td>
                    <td class="action-cell">
                        <button type="button" class="action-btn inquire-btn">Inquire</button>
                        <button type="button" class="action-btn contact-btn">Contact Seller</button>
                        <button type="button" class="action-btn bookmark-btn"><span class="btn-icon" aria-hidden="true">♥</span> Bookmark</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                            <strong>No properties are currently available.</strong><br>
                            Please try refreshing the page or check back later.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
                </table>
            </div>
    </div>
        
</body>
 <footer>
        <p>© 2026 RHS by C.J.C. All rights reserved.</p>
    </footer>
        <script src="js/index.js" defer></script>
        <script src="js/jquery.js" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</body>
</html>