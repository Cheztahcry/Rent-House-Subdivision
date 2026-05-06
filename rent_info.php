<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent House Registration</title>
    <!-- Using the style we created as reference -->
    <link rel="stylesheet" href="css/rent_info_style.css">
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

            <h1>Rent House Information</h1>
            
            <form action="database.php" method="post" id="rent-form">
                <!-- Monthly Rent Field -->
                <div class="field-group">
                    <label for="rent_price">Rent Price Monthly</label>
                    <div class="field-row">
                        <input type="number" name="rentprice" id="rent_price" placeholder="Enter Monthly Rent (e.g. 5000)" required>
                    </div>
                </div>

                <!-- Down Payment Field -->
                <div class="field-group">
                    <label for="down_payment">Down Payment</label>
                    <div class="field-row">
                        <input type="number" name="downpayment" id="down_payment" placeholder="Enter Down Payment (e.g. 2000)" required>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="button-row">
                    <button type="submit" name="submit_rent" id="submit">Submit Info</button>
                    <button type="button" id="clear" onclick="this.form.reset()">Clear Fields</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Optional: Linking your existing JS if needed for other functions -->
    <script src="script/index.js"></script>
</body>
</html>