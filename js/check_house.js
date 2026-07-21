document.addEventListener("DOMContentLoaded", () => {
    const message = document.getElementById("message");
    const block_input = document.querySelector('input[name="blocknumber"]');
    const lot_input = document.querySelector('input[name="lotnumber"]');
    const duplicate_input = [block_input, lot_input];
    duplicate_input.forEach(duplicates => {
        
        if (duplicates) {
            duplicates.addEventListener('keyup', (event) => {
                const block_val = block_input.value.trim()
                const lot_val = lot_input.value.trim()
                if (block_val === "" || lot_val === "") {
                    message.textContent = "";
                    return;
                }
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'check_house.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        var trim_response = xhr.responseText.trim();   
                        try {
                            var isDuplicate = JSON.parse(trim_response);
                            
                            if(isDuplicate) {
                                message.textContent = "House number is already taken";
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
                
                var params = new URLSearchParams({
                    'blocknumber' : block_input.value,
                    'lotnumber' : lot_input.value,
                }).toString();
                
                xhr.send(params);
            });
        }
    });
});