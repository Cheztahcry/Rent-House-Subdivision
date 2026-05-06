<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Information</title>
    <link rel="stylesheet" href="css/owner_info_style.css">
</head>
<body>
    <div class="student form">
        <div class="container">
            <div class="page-header">
                <nav class="page-nav">
                    <a class="nav-link" href="index.php">Home</a>
                </nav>
            </div>
            <h1>Owner Information</h1>
            <form action="database.php" method="post" id="owner-enrollment">
                <div class="field-group">
                    <label>Full Name</label>
                    <div class="field-row">
                        <input type="text" name="lname" placeholder="Last Name" required>
                        <input type="text" name="fname" placeholder="First Name" required>
                        <input type="text" name="mname" id="mname" placeholder="Middle Name">
                        <label class="checkbox-label">
                            <input type="checkbox" name="check_mname" id="check_mname" value="N/A"> I have no middle name
                        </label>
                    </div>
                </div>
                <div class="field-group">
                    <label>Address</label>
                    <div class="field-row">
                        <input type="number" name="blocknumber" id="blocknumber" placeholder="Block Number" min="1">
                        <input type="number" name="lotnumber" id="lot_number" placeholder="Lot Number" min="1">
                    </div>
                </div>
                <div class="field-group">
                    <label>Age</label>
                    <div class="field-row">
                        <input type="number" name="age" id="age" placeholder="Age" min="1">
                    </div>
                </div>
                <div class="field-group">
                    <label>Gender</label>
                    <div class="field-row">
                        <label>
                            <input type="radio" name="gender" value="Male"> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Female"> Female
                        </label>
                    </div>
                </div>
                <div class="field-group">
                    <label for="contact_number">Contact Number</label>
                    <div class="field-row">
                        <input type="number" name="contactnumber" id="contact_number" placeholder="Contact Number" maxlength="11">
                    </div>
                </div>
                
                <div class="button-row">
                    <button type="submit" name="submit_owner" id="submit">Next Section</button>
                    <button type="button" id="clear">Clear Fields</button>
                </div>
            </form>
        </div>
    </div>
    <script src="script/index.js"></script>
</body>
</html>