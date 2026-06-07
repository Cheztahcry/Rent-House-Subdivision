const search_bar = document.getElementById("search_bar");
const search_result = document.getElementById("search-results");
$(document).ready(function(){
    $(search_bar).keyup(function(){
        var input = $(this).val();
        if (input != ""){
            $.ajax({
                url:"search_class.php",
                method:"POST",
                data:{input:input},
                success:function(data){ 
                    $(search_result).html(data).show();
                }   
            })
        }else{
            $(search_result).css("display", "none");

        }
    })
})
