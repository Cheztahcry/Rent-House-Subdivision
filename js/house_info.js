const house_form = document.getElementById('house-form');
let radioButtons = document.querySelectorAll('input[name="house_status"]');
const rent_form = document.getElementById('rent-form')
const sale_form = document.getElementById('sale-form')
const rent_form_required = rent_form.querySelectorAll('input, select, textarea');
const sale_form_required = sale_form.querySelectorAll('input, select, textarea');






function changeInfo() {
    const checkedRadio = document.querySelector('input[name="house_status"]:checked');
    


    if (checkedRadio) {
        if (checkedRadio.value === "For Sale") {
            house_form.action = 'sale_info_class.php';
            rent_form.style.display = "none";
            sale_form.style.display = "block";
            sale_form_required.forEach(sales => 
            {sales.required = true});
            rent_form_required.forEach(rent => {rent.required = false});
            
        }
        else if (checkedRadio.value === "For Rent") {
            house_form.action = 'rent_info_class.php';
            sale_form.style.display = "none";  
            rent_form.style.display = "block";
            sale_form_required.forEach(sales => {sales.required = false});
            rent_form_required.forEach(rent => {rent.required = true});   
        }
    }
    else
        {
        rent_form.style.display = "none";
        sale_form.style.display = "none";
        
        }
}

changeInfo();
radioButtons.forEach(radio => {
    radio.addEventListener('change', changeInfo);
});


