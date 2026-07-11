document.addEventListener("DOMContentLoaded", () => {
    const login_btn = document.querySelector("#login");
    const email_fld = document.querySelector("#email");
    const password_fld = document.querySelector("#password");
    const validation_message = document.querySelector("#validate_box");
    const ok_btn = document.querySelector("#ok-btn");



    function login_validation() {
        const email_val = email_fld.value.trim()
        const password_val = password_fld.value.trim()
        const fields = [email_val, password_val];
        const allFieldsFilled = fields.every(value => value !== "");
        const email_check = validateEmail(email_val)
        if (allFieldsFilled && email_check) {
            login_btn.style.backgroundColor = "#484e26";
            login_btn.disabled = false;
        }
        else {
            login_btn.style.backgroundColor = "#3c3d37";
            login_btn.disabled = true;
        }
        
    }
    function hide_message(){
        validation_message.style.display = "none";
    }
    function show_message(){
        validation_message.style.display = "block";
    }
    function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
    }
    
    email_fld.addEventListener("input", login_validation);
    password_fld.addEventListener("input", login_validation);
    ok_btn.addEventListener("click", hide_message);
    login_btn.addEventListener("click", show_message);
    login_validation();


})

