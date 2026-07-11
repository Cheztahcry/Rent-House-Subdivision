document.addEventListener("DOMContentLoaded", () => {
    const house_form = document.getElementById('house-form');
    let radioButtons = document.querySelectorAll('input[name="house_status"]');
    const rent_form = document.getElementById('rent-form')
    const sale_form = document.getElementById('sale-form')
    const rent_form_required = rent_form.querySelectorAll('input, select, textarea');
    const sale_form_required = sale_form.querySelectorAll('input, select, textarea');
    

    const message = document.getElementById("message");
    const blockinput = document.querySelector('input[name="email"]');
    const lotinput = document.querySelector('input[name="email"]');
    const submit_button = document.querySelector('button[name="submit_owner"]')
    const form = document.querySelector('form');
    input.addEventListener('keyup', (event) => {
        if (input.value.trim() === "") {
            message.textContent = "";
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'owner_info_class.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function(){
        if (xhr.status == 200){
            var trim_response = xhr.responseText.trim();
            
            try {
                var isDuplicate = JSON.parse(trim_response);
                
                if(isDuplicate){
                    message.textContent = "Email is already taken";
                    message.style.color = "red";
                    submit_button.disabled = true;
                    submit_button.style.BackgroundColor = "red"
                    
                }
                else{
                    submit_button.disabled = false;
                }
            } catch (e) {
                console.error("JSON Parse failed! The server actually sent: ", xhr.responseText);
            }
        }
        };
        var params = 'email=' + encodeURIComponent(input.value);
        xhr.send(params);
    });
    function changeInfo() {
    const checkedRadio = document.querySelector('input[name="house_status"]:checked');



    if (checkedRadio) {
        if (checkedRadio.value === "For Sale") {
            house_form.action = 'sale_info_class.php';
            rent_form.style.display = "none";
            sale_form.style.display = "block";
            sale_form_required.forEach(sales => { sales.required = true });
            rent_form_required.forEach(rent => { rent.required = false });

        }
        else if (checkedRadio.value === "For Rent") {
            house_form.action = 'rent_info_class.php';
            sale_form.style.display = "none";
            rent_form.style.display = "block";
            sale_form_required.forEach(sales => { sales.required = false });
            rent_form_required.forEach(rent => { rent.required = true });
        }
    }
    else {
        rent_form.style.display = "none";
        sale_form.style.display = "none";

    }
}

    changeInfo();
    radioButtons.forEach(radio => {
        radio.addEventListener('change', changeInfo);
    });
});




