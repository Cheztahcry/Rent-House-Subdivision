<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class = "student form">
    <div class="container">
    <h1>Owner Information</h1>
    <form action = "database.php" method="post" id = "enrollment">
    <label> Full Name: <input type="text" name="lname" placeholder="Last Name" > <input type="text" name="fname" placeholder="First Name" > <input type="text" name="mname" id= "mname" placeholder="Middle Name" > <input type = "checkbox" name = "check_mname" id ="check_mname" value = "N/A"> I have no middle name</label> <br> <br>
    <label> Address : <input type="number" name="address" id = "block" placeholder="Block Number" > <input type="number" name="address" id = "lot" placeholder="Lot Number" > <br> <br>
    Age: <input type="number" name="age" id= "age" placeholder="Age" min = "1" > </label> <br> <br>
    <label> Gender: <input type="radio" name="gender" id="gender" value="Male"> Male <input type="radio" name="gender" id="gender" value="Female"> Female </label> <br> <br>
    <label for="contact_number">Contact Number: <input type="tel" name="contact_number" id ="contact_number" placeholder="Contact Number" maxlength="11" pattern="[0-9]{11}" ></label> &nbsp 
    <br><br> </div>


    <div class="container">
    <h1>Rent House Information</h1>
    <label for="contact_number">Rent Price Monthly: <input type="tel" name="contact_number" id ="contact_number" placeholder="Rent Price" ></label><br> <br>
    <label for="contact_number">Down Payment: <input type="tel" name="contact_number" id ="contact_number" placeholder="Down Payment" ></label>


    
</div>
<br><br>
    <button type="submit" name="submit" id = "submit ">Submit</button>
    <button type = "button" id = "clear">Clear Fields</button>
    
    </form> </div>
    <br>
    <script src="script/index.js"></script>
</body>
</html>