document.addEventListener("DOMContentLoaded", () => {
    //Make every messages/warnings/submit button share the same name or id for every file
    const message = document.querySelector('div[name="message"]');
    const submit_button = document.querySelector('button[name="submit"]');
    const block_input = document.querySelector('input[name="blocknumber"]');
    const lot_input = document.querySelector('input[name="lotnumber"]');
    const email_input = document.querySelector('input[name="email"]');
    let duplicate_input = [block_input, lot_input, email_input];
    duplicate_input = duplicate_input.filter(input => input !== null);
    function ajaxHelper(data, result) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'duplicates_handler.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () { 
            if (xhr.status == 200) {
                var trim_response = xhr.responseText.trim();
                const jsonString = JSON.stringify(isDuplicate);
                alert(jsonString);
                
                try {
                    var isDuplicate = JSON.parse(trim_response);
                    if (isDuplicate.email || isDuplicate.house) {                        
                        message.textContent = result;    
                        message.style.color = "red";
                        submit_button.style.backgroundColor = "#222523";
                        submit_button.disabled = true;
                    }  
                } catch (e) {
                    console.error("JSON Parse failed! The server actually sent: ", xhr.responseText);
                }
                return;
            }
        };

        var params = new URLSearchParams(data).toString();
        
        xhr.send(params);

    }

    duplicate_input.forEach(duplicates => {

    if (duplicates) {
        duplicates.addEventListener('keyup', (event) => {
            const block_val = block_input?.value.trim() || "";
            const lot_val = lot_input?.value.trim() || "";
            const email_val = email_input?.value.trim() || "";
            if (duplicates === block_input || duplicates === lot_input) {
                
                if (block_val === "" || lot_val === ""){
                    message.textContent = "";
                    submit_button.style.backgroundColor = "#484e26";
                    submit_button.disabled = false;
                    return;
                }
                
                ajaxHelper({blocknumber: block_val, lotnumber: lot_val}, "House address is already taken");
            }
            
            if (duplicates === email_input) {
                if (email_val === ""){
                    message.textContent = "";
                    submit_button.style.backgroundColor = "#484e26";
                    submit_button.disabled = false;
                    return;
                }
                     
                ajaxHelper({email: email_val}, "Email address is already taken");
            }
        });
    }
    });
});