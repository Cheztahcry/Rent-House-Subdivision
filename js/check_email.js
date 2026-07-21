document.addEventListener("DOMContentLoaded", () => {
    const message = document.getElementById("message");
    const email_input = document.querySelector('input[name ="email"]');
    const submit_button = document.querySelector('button[name="submit_owner"');
    const duplicate_input = [email_input];
    
    duplicate_input.forEach(duplicates => {
        
        duplicates.addEventListener('keyup', (event) => {
        submit_button.disabled = false;
        submit_button.style.backgroundColor = "rgba(62, 60, 43, 0.688)";

            if (duplicates.value.trim() === "") 
            {
                message.textContent = "";
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'check_duplicates.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function()
            
            {
            if (xhr.status == 200)
                {
                    var trim_response = xhr.responseText.trim();
                    
                    try
                    {
                        var isDuplicate = JSON.parse(trim_response);
                        
                        if(isDuplicate){
                            message.textContent = "Email is already taken";
                            message.style.color = "red";
                            submit_button.disabled = true;
                            submit_button.style.backgroundColor = "#151610";
                            
                            
                        }
                    } catch (e) 
                    {
                        console.error("JSON Parse failed! The server actually sent: ", xhr.responseText);
                    }
                }
            };
            var params = new URLSearchParams({
                'email' : duplicates.value,
            }).toString();
            
            xhr.send(params);
            
        });

    })
    
});