const rent_dashboard = document.getElementById("rent-dashboard")
const rent_button = document.getElementById("rent-button")
const sale_dahboard = document.getElementById("sale-dashboard")
const sale_button = document.getElementById("sale-button")


rent_button.addEventListener("click", function(){
    sale_dahboard.style.display = "none";
    rent_dashboard.style.display = "block";
})
sale_button.addEventListener("click", function(){
    sale_dahboard.style.display = "block";
    rent_dashboard.style.display = "none";
})
