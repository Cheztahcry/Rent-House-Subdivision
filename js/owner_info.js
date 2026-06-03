const middle_name = document.getElementById("mname")

document.getElementById("check_mname").addEventListener("change", function () {
    if (middle_name.disabled == true){
       middle_name.disabled = false
       middle_name.style.backgroundColor = "#ffffff"
    }
    else if (middle_name.disabled == false){
       middle_name.disabled = true
       middle_name.style.backgroundColor = "#cccccc"
    }

})

document.getElementById("clear").addEventListener("click", function() {
    document.getElementById("owner-enrollment").reset();
    middle_name.disabled = false;
    middle_name.style.backgroundColor = "#ffffff"
});