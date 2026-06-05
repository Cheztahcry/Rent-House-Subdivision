<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Radio Button Test</title>
</head>
<body>

    <form id="house-form" action="default.php" method="POST">
        <h3>Select Status:</h3>
        <label><input type="radio" name="house_status" value="For Sale"> For Sale</label>
        <label><input type="radio" name="house_status" value="For Rent"> For Rent</label>
        
        <br><br>
        <button type="submit">Submit Form</button>
    </form>

    <script>
        const houseForm = document.getElementById("house-form");
        const radioButtons = document.querySelectorAll('input[name="house_status"]');

        function updateAction() {
            const checkedRadio = document.querySelector('input[name="house_status"]:checked');
            if (checkedRadio) {
                if (checkedRadio.value === 'For Sale') {     
                    houseForm.action = "sale_info_class.php";
                } else if (checkedRadio.value === 'For Rent') {
                    houseForm.action = "rent_info_class.php"; 
                }
                console.log("Action changed to: " + houseForm.action);
            }
        }

        // Listen for changes
        radioButtons.forEach(radio => {
            radio.addEventListener('change', updateAction);
        });
    </script>

</body>
</html>