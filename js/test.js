$(document).ready(function(){
    const lot_number = document.getElementById("lot_number");
    const block_number = document.getElementById("blocknumber");
    const message = document.getElementById("message");
    $(lot_number).add(block_number).keyup(function(){
        var lot = $(lot_number).val();
        var block = $(block_number).val();
        if (lot && block != ""){
            $.ajax({
                url:"check_duplicates.php",
                method:"POST",
                data:{lotnumber:lot, blocknumber:block},
                success:function(data){ 
                    $(message).html(data).show();
                 
                }
        
                
            })
        }else{
            $(message).css("display", "none");

        }
    })
})
