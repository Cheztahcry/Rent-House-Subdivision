let radioButtons = document.querySelectorAll('input[name="acct-stat"]');
const acct_info = document.getElementById("acct-info-content");
const acct_tran = document.getElementById("acct-tran-content");
const input_fields = acct_info.querySelectorAll('input');
const password = document.getElementById("password")
const edit_button = document.getElementById("edit");
const save_button = document.getElementById("save");
let button_stat = false








function changeInfo() {
    const checkedRadio = document.querySelector('input[name="acct-stat"]:checked');

    if (checkedRadio) {
        if (checkedRadio.value === "Account Information") {
            acct_info.style.display = "block";
            acct_tran.style.display = "none";
            save_button.style.display = "none";
            input_fields.forEach(input =>{
                input.disabled = true;
                input.style.backgroundColor = "#cccccc"});
        }
        else if (checkedRadio.value === "Account Transaction") {
            acct_info.style.display = "none";  
            acct_tran.style.display = "block"; 

        }
    }
    else
        {
        acct_info.style.display = "none";
        acct_tran.style.display = "none";
        
        }
        
}
edit_button.addEventListener("click", function(){
    button_stat = !button_stat;
    if (button_stat == true){
        edit_button.style.backgroundColor = "#cccccc"
        password.disabled = false
        password.style.backgroundColor = "#ffffff"
        save_button.style.display = "block";
    }
    else if (button_stat == false){
        edit_button.style.backgroundColor = "#ffffff"
        password.disabled = true
        password.style.backgroundColor = "#cccccc"
        save_button.style.display = "none";
    }
})

changeInfo();
radioButtons.forEach(radio => {
    radio.addEventListener('change', changeInfo);
});


