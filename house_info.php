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
            
            <form action = "rent_info_class.php" method="post" id="house-form">
                <!-- Monthly Rent Field -->
                <div class="field-group">
                    <label>Address</label>
                    <div class="field-row">
                        <input type="number" name="blocknumber" id="blocknumber" placeholder="Block Number" min="1">
                        <input type="number" name="lotnumber" id="lot_number" placeholder="Lot Number" min="1">
                    </div>
                </div>
                <div class="field-group">
                    <label for="rent_price">House Status</label>
                    <div class="field-row">
                        <input type="radio" value = "For Sale" name="house_status" id="for_sale" required>For Sale
                        <input type="radio" value = "For Rent" name="house_status" id="for_rent" required>For Rent
                    </div>
                </div>
                <div id = "sale-form">
                    <div class="field-group">
                        <label for="rent_price">House Price</label>
                        <div class="field-row">
                            <input type="number" name="houseprice" id="house_price" placeholder="Enter Desired Amount" >
                        </div>
                    </div>
                </div>
                <div id = "rent-form">
                    <div class="field-group">
                        <label for="rent_price">Rent Price Monthly</label>
                        <div class="field-row">
                            <input type="number" name="rentprice" id="rent_price" placeholder="Enter Monthly Rent (e.g. 5000)" >
                        </div>
                    </div>
                    <div class="field-group">
                        <label for="down_payment">Down Payment</label>
                        <div class="field-row">
                            <input type="number" name="downpayment" id="down_payment" placeholder="Enter Down Payment (e.g. 2000)" >
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="button-row">
                    <button type="submit" name="submit" id="submit">Submit Info</button>
                    <button type="button" id="clear" onclick="this.form.reset()">Clear Fields</button>
                </div>
            </form>
        </div>
    </div>
    

    <script src="js/house_info.js" defer></script>
</body>
</html>