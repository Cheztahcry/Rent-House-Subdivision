const middle_name = document.getElementById("mname")
const age = document.getElementById("age")
const password = document.getElementById("password")
const confirm_password = document.getElementById("confirm-password")

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
    clearValidationMessages();
});

// ====== EMAIL AND PASSWORD VALIDATION ======

// Email validation function
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Password validation function
function validatePassword(password) {
    const errors = [];
    
    if (password.length < 8) {
        errors.push("Password must be at least 8 characters long");
    }
    if (!/[A-Z]/.test(password)) {
        errors.push("Password must contain at least one uppercase letter");
    }
    if (!/[a-z]/.test(password)) {
        errors.push("Password must contain at least one lowercase letter");
    }
    if (!/[0-9]/.test(password)) {
        errors.push("Password must contain at least one number");
    }
    return errors;
}

// Display validation error message
function showValidationError(fieldId, message) {
    const field = document.getElementById(fieldId);
    let errorDiv = field.parentElement.querySelector(".error-message");
    
    if (!errorDiv) {
        errorDiv = document.createElement("div");
        errorDiv.className = "error-message";
        errorDiv.style.color = "red";
        errorDiv.style.fontSize = "12px";
        errorDiv.style.marginTop = "5px";
        field.parentElement.appendChild(errorDiv);
    }
    
    errorDiv.textContent = message;
    field.style.borderColor = "red";
}

// Clear validation error message
function clearValidationError(fieldId) {
    const field = document.getElementById(fieldId);
    let errorDiv = field.parentElement.querySelector(".error-message");
    
    if (errorDiv) {
        errorDiv.remove();
    }
    
    field.style.borderColor = "";
}

// Age validation function
function validateAge(age) {
    const ageNum = parseInt(age);
    if (isNaN(ageNum) || ageNum < 18) {
        return false;
    }
    return true;
}

// Clear all validation messages
function clearValidationMessages() {
    clearValidationError("username");
    clearValidationError("password");
    clearValidationError("age");
}

// Email field validation on blur
document.getElementById("username").addEventListener("blur", function() {
    const email = this.value.trim();
    
    if (email === "") {
        clearValidationError("username");
        return;
    }
    
    if (!validateEmail(email)) {
        showValidationError("username", "Please enter a valid email address");
    } else {
        clearValidationError("username");
    }
});

// Email field validation on input (real-time)
document.getElementById("username").addEventListener("input", function() {
    if (this.value.trim() !== "" && !validateEmail(this.value.trim())) {
        this.style.borderColor = "#ffcccc";
    } else {
        this.style.borderColor = "";
    }
});

// Password field validation on blur
password.addEventListener("blur", function() {
    const password = this.value;
    
    if (password === "") {
        clearValidationError("password");
        return;
    }
    
    const errors = validatePassword(password);
    
    if (errors.length > 0) {
        showValidationError("password", errors.join(", "));
    } else {
        clearValidationError("password");
    }
});

// Password field validation on input (real-time feedback)
password.addEventListener("input", function() {
    const password = this.value;
    const errors = validatePassword(password);
    
    if (password !== "" && errors.length > 0) {
        this.style.borderColor = "#ffcccc";
    } else {
        this.style.borderColor = "";
    }
});
confirm_password.addEventListener("input", function() {
    const c_password = this.value;
    if (c_password !== password && c_password !== "") {
        this.style.borderColor = "#f80000";
    } else {
        this.style.borderColor = "";
    }
});

// Age field validation on blur
age.addEventListener("blur", function() {
    const age = this.value.trim();
    
    if (age === "") {
        clearValidationError("age");
        return;
    }
    
    if (!validateAge(age)) {
        showValidationError("age", "You can't register if your age is below 18 years old");
    } else {
        clearValidationError("age");
    }
});

// Age field validation on input (real-time)
age.addEventListener("input", function() {
    if (this.value.trim() !== "" && !validateAge(this.value.trim())) {
        this.style.borderColor = "#ffcccc";
    } else {
        this.style.borderColor = "";
    }
});

// Submitting without input validation
document.getElementById("owner-enrollment").addEventListener("submit", function(e) {
    const email = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;
    const age = document.getElementById("age").value.trim();
    
    let isValid = true;
    
    // Validate email
    if (email === "") {
        showValidationError("username", "Email is required");
        isValid = false;
    } else if (!email.includes("@")) {
        showValidationError("username", "you can't register if your email does not have @");
        isValid = false;
    } else if (!validateEmail(email)) {
        showValidationError("username", "Please enter a valid email address");
        isValid = false;
    } else {
        clearValidationError("username");
    }
    
    // Validate password
    if (password === "") {
        showValidationError("password", "Password is required");
        isValid = false;
    } else {
        const errors = validatePassword(password);
        if (errors.length > 0) {
            showValidationError("password", errors.join(", "));
            isValid = false;
        } else {
            clearValidationError("password");
        }
    }
    
    // Validate age
    if (age === "") {
        showValidationError("age", "Age is required");
        isValid = false;
    } else if (!validateAge(age)) {
        showValidationError("age", "you can't register if your age is below 18 years old");
        isValid = false;
    } else {
        clearValidationError("age");
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});


