let radioButtons = document.querySelectorAll('input[name="property_status"]');
const sale_dahboard = document.getElementById("sale-dashboard")
const rent_dashboard = document.getElementById("rent-dashboard")

function changeInfo() {
    const checkedRadio = document.querySelector('input[name="property_status"]:checked');
    if (checkedRadio) {
        if (checkedRadio.value === "rent") {   
            rent_dashboard.style.display = "block"
            sale_dahboard.style.display = "none"
        }
        else if (checkedRadio.value === "sale") {
            rent_dashboard.style.display = "none"
            sale_dahboard.style.display = "block"
        }
    }
    else
        {
            rent_dashboard.style.display = "none"
            sale_dahboard.style.display = "none"
        
        }
}

changeInfo();
radioButtons.forEach(radio => {
    radio.addEventListener('change', changeInfo);
});
