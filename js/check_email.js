$(document).ready(function(){
    const email = document.getElementById("username");
    const message = document.getElementById("message");
    $(email).keyup(function(){
        var user_email = $(email).val();
        if (user_email != ""){
            $.ajax({
                url:"check_email.php",
                method:"POST",
                data:{email:user_email},
                success:function(data){ 
                    $(message).html(data).show();
                    
                }
                
            })
        }else{
            $(message).css("display", "none");

        }
    })
})