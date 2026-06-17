<?php
session_start();
$user = false;
$acc_rent = false;
$acc_sale = false;
// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['owner_picture'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    include_once 'owner_info_class.php';
    $owner = new OwnerInfo();
    $userId = $_SESSION['user_id'];
    $file = $_FILES['owner_picture'];
    $allowed = ['image/jpeg','image/png','image/gif'];
    if ($file['error'] === UPLOAD_ERR_OK && in_array($file['type'], $allowed)) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = $userId . '_' . time() . '.' . $ext;
        $destDir = __DIR__ . '/assets/img/uploads/';
        if (!is_dir($destDir)) mkdir($destDir, 0755, true);
        if (move_uploaded_file($file['tmp_name'], $destDir . $newName)) {
            $owner->update_owner($userId, ['picture' => $newName]);
        }
    }
    header('Location: owner_dashboard.php');
    exit;
}

if(isset($_SESSION["user_id"])){
    include_once __DIR__ . '/owner_info_class.php';
    include_once __DIR__ .  '/rent_info_class.php';
    include_once __DIR__ .  '/sale_info_class.php';
    $owner = new OwnerInfo();
    $rent = new RentInfo();
    $sale = new SaleInfo();
    try{
        $user = $owner->show_ownerinfo($_SESSION["user_id"]);
        $acc_rent = $rent->account_transactions($_SESSION["user_id"]);
        $acc_sale = $sale->account_transactions($_SESSION["user_id"]);
    }catch (PDOException $e) {
        echo "Can't find the user data";
    } 
    
}
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent House Registration</title>
    <!-- Using the style we created as reference -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/owner_info_style.css">
</head>
<body>
    <div class="student form">
        <div class="container">
            <!-- Independent Header -->
            <div class="page-header">
                <nav class="page-nav">
                    <a class="nav-link" href="index.php">Home</a>
                </nav>
            </div>

            <h1>Account Dashboard</h1>

                <?php if($user): ?>
                <div class="profile-upload" style="display:flex;align-items:center;gap:16px;margin-bottom:18px;">
                    <div class="profile-preview">
                        <?php if(!empty($user->picture)): ?>
                            <img src="assets/img/uploads/<?= htmlspecialchars($user->picture) ?>" alt="Profile" class="profile-avatar" style="width:64px;height:64px;border-radius:50%;object-fit:cover;border:2px solid #fff;box-shadow:0 6px 18px rgba(0,0,0,0.12);">
                        <?php else: ?>
                            <div class="profile-placeholder" style="width:64px;height:64px;border-radius:50%;background:#f1f1f1;display:flex;align-items:center;justify-content:center;color:#6b6b6b;font-weight:700;">?</div>
                        <?php endif; ?>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <label for="owner_picture">Change profile photo</label>
                        <input type="file" name="owner_picture" id="owner_picture" accept="image/*">
                        <button type="submit">Upload</button>
                    </form>
                </div>
                <?php endif; ?>

                <div class="acct-tab" id="acct-tab">
                    <div class="acct-tabs">
                        <label class="status-option acct-tab-button">
                            <input type="radio" name="acct-stat" id="acct-info-radio" value="Account Information" checked>
                            <span>Account Information</span>
                        </label>
                        <label class="status-option acct-tab-button">
                            <input type="radio" name="acct-stat" id="acct-tran-radio" value="Account Transaction">
                            <span>Account Transaction</span>
                        </label>
                        <label class="status-option acct-tab-button">
                            <input type="radio" name="acct-stat" id="acct-tran-radio" value="Account Transaction">
                            <span>Bookmarks</span>
                        </label>
                    </div>
                </div>

                    

                    <?php if($user):?>
                    <div class="acct-panel" id="acct-info-content">
                        <div class="button-row">
                            <button type="button" id="edit" class="secondary-btn">Edit Information</button>
                            <button type="button" id="save" class="primary-btn">Save Information</button>
                        </div>
                        <div class="field-group">
                            <label>Full Name</label>
                            <div class="field-row">
                                <input type="text" name="lname" placeholder="Last Name" required value="<?= htmlspecialchars($user->lname) ?>">
                                <input type="text" name="fname" placeholder="First Name" required value="<?= htmlspecialchars($user->fname) ?>">
                                <input type="text" name="mname" id="mname" placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="field-group">
                            <label>Age</label>
                            <div class="field-row">
                                <input type="number" name="age" id="age" placeholder="Age" min="1" value="<?= htmlspecialchars($user->age) ?>">
                            </div>
                        </div>
                        <div class="field-group">
                            <label>Gender</label>
                            <div class="field-row">
                                <input type="text" name="gender" placeholder="Gender" required value="<?= htmlspecialchars($user->gender) ?>">
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="contact_number">Contact Number</label>
                            <div class="field-row">
                                <input type="tel" name="contactnumber" id="contact_number" placeholder="Contact Number" maxlength="11">
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="username">Email</label>
                            <div class="field-row">
                                <input type="email" name="email" id="username" placeholder="Email" value="<?= htmlspecialchars($user->email) ?>">
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="password">Change Password</label>
                            <div class="field-row">
                                <input type="password" name="password" id="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="password">User ID</label>
                            <div class="field-row">
                                <label><?= htmlspecialchars($user->user_uid) ?></label>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="acct-panel hidden" id="acct-tran-content">
                        <div class="transaction-summary">
                            <h2>Account Transactions</h2>
                        </div>
                        <div class="transaction-card">
                            <?php if($acc_rent && count($acc_rent) > 0):?>
                            <?php foreach ($acc_rent as $rent): ?> 
                            <div class="transaction-card__header">
                                <span>For Rent</span>
                            </div>
                            <div class="transaction-card__body">
                                <p class="transaction-card__message">Block: <?= $rent->blocknumber ?></p>
                                <p class="transaction-card__message">Lot: <?= $rent->lotnumber ?></p>
                                <p class="transaction-card__message">Rent: <?= $rent->rentprice ?></p>
                                <p class="transaction-card__message">Down Payment: <?= $rent->downpayment ?></p>
                            </div>
                            <?php endforeach; ?>
                            <?php if($acc_sale && count($acc_sale) > 0):?>
                            <?php foreach ($acc_sale as $sale): ?> 
                            <div class="transaction-card__header">
                                <span>For Sale</span>
                            </div>
                            <div class="transaction-card__body">
                                <p class="transaction-card__message">Block: <?= $sale->blocknumber ?></p>
                                <p class="transaction-card__message">Lot: <?= $sale->lotnumber ?></p>
                                <p class="transaction-card__message">Price: <?= $sale->houseprice ?></p>
                            </div>
                            <?php endforeach; ?>
                            
                            <?php else: ?>
                            <div class="transaction-card__body">
                                <p class="transaction-card__message">Your account is active, and all updates will appear here once available.</p>
                            </div>
                        </div>
                    </div>
                    
                    <?php endif; ?>
                    <?php endif; ?>
                
                


        </div>
    </div>
    

    <script src="js/owner_dashboard.js" defer></script>
</body>
</html>