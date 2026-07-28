document.addEventListener("DOMContentLoaded", () => {
    const login_btn = document.querySelector("#login");
    const email_fld = document.querySelector("#email");
    const password_fld = document.querySelector("#password");
    const remember_me = document.querySelector('input[name="remember_me"]');
    const login_form = document.getElementById("login-form");
    const message = document.querySelector('div[name="message"]');



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
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    email_fld.addEventListener("input", login_validation);
    password_fld.addEventListener("input", login_validation);
    login_validation();








    login_form.addEventListener("submit", function (event) {

        event.preventDefault();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'login_handler.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status == 200) {
                var trim_response = xhr.responseText.trim();
                try {
                    var isValid = JSON.parse(trim_response);
                    if (isValid){
                        window.location.href = "index.php";
                    }
                    else{
                        message.textContent = "Wrong email or password";
                        message.style.color = "red";
                    }
                } catch (e) {
                    console.error("JSON Parse failed! The server actually sent: ", xhr.responseText);
                }
            }
        };

        const params = new URLSearchParams({
            email: email_fld.value,
            password: password_fld.value,
            cookies: remember_me.checked
        }).toString();
        xhr.send(params);

    })







})

