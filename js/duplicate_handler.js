document.addEventListener("DOMContentLoaded", () => {
    //Make every messages/warnings share the same name or id
    const message = document.querySelector('div[name="message"]');
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
                
                try {
                    var isDuplicate = JSON.parse(trim_response);
                    const stringifiedData = JSON.stringify(isDuplicate);
                    if (isDuplicate) {
                        message.textContent = result;    
                        message.style.color = "red";
                    } else {
                        message.textContent = "";  
                        
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
                
                if (block_val === "" || lot_val === "") return;
                
                ajaxHelper({block: block_val, lot: lot_val}, "House address is already taken");
            }
            
            if (duplicates === email_input) {
                if (email_val === "") return; 
                ajaxHelper({email: email_val}, "Email address is already taken");
            }
        });
    }
    });
});