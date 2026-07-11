document.addEventListener("DOMContentLoaded", () => {
    const message = document.getElementById("message");
    const input = document.querySelector('input[name="email"]');
    const form = document.querySelector('form');
    input.addEventListener('keyup', (event) => {
        if (input.value.trim() === "") {
            message.textContent = "";
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'check_email.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function(){
        if (xhr.status == 200){
            var trim_response = xhr.responseText.trim();
            
            try {
                var isDuplicate = JSON.parse(trim_response);
                
                if(isDuplicate){
                    message.textContent = "Email is already taken";
                    message.style.color = "red"
                    submit_button.disabled = true
                    
                }
            } catch (e) {
                console.error("JSON Parse failed! The server actually sent: ", xhr.responseText);
            }
        }
};
        var params = 'email=' + encodeURIComponent(input.value);
        xhr.send(params);
    });
});
