<?php
session_start();
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
            

                <div class="acct-tab" id = "acct-tab">
                        <label class="status-option">
                        <input type="radio" name="acct-stat" id= "acct-info-radio" value="Account Information">
                        <span>Account Information</span>
                         </label>
                        <label class="status-option">
                        <input type="radio" name="acct-stat" id= "acct-tran-radio" value="Account Transaction">
                        <span>Account Transaction</span>
                        </label>
                    <?php if($user):?>
                    <div id = "acct-info-content">
                        <button type="button" id="edit">Edit Information</button>
                        <div class="field-group">
                            <label>Full Name</label>
                            <div class="field-row">
                                <input type="text" name="lname" placeholder="Last Name" required value = <?= htmlspecialchars($user->fname) ?>>
                                <input type="text" name="fname" placeholder="First Name" required value = <?= htmlspecialchars($user->lname) ?>>
                                <input type="text" name="mname" id="mname" placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="field-group">
                            <label>Age</label>
                            <div class="field-row">
                                <input type="number" name="age" id="age" placeholder="Age" min="1" value = <?= htmlspecialchars($user->age) ?>>
                            </div>
                        </div>
                        <div class="field-group">
                            <label>Gender</label>
                            <div class="field-row">
                                <input type="text" name="lname" placeholder="Last Name" required value = <?= htmlspecialchars($user->gender) ?>>
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
                                <input type="text" name="email" id="username" placeholder="Email" value = <?= htmlspecialchars($user->email) ?>>
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="password">Change Password</label>
                            <div class="field-row">
                                <input type="password" name="password" id="password" placeholder="Password" value>
                            </div>
                        </div>
                        <?php endif;?>
                        <button type="button" id="save">Save Information</button>
                        
                        

                    </div>


                    <div id = "acct-tran-content">
                        <div class="status-toggle">
                            <label class="status-option">
                            <input type="radio" name="property_status" id= "sale-radio" value="sale">
                            <span>For Sale</span>
                            </label>
                            <label class="status-option">
                            <input type="radio" name="property_status" id= "rent-radio" value="rent">
                            <span>For Rent</span>
                            </label>
                        </div>
                        
                    </div>
                    
                
                </div>
                


        </div>
    </div>
    

    <script src="js/owner_dashboard.js" defer></script>
</body>
</html>