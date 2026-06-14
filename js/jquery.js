$(document).ready(function(){
    // Move these INSIDE the ready function so they don't crash
    const search_bar = document.getElementById("search_bar");
    const search_result = document.getElementById("search-results");
    const search_button = document.getElementById('search-button');
    
    // Grab the dashboards so we can hide them during a search
    const sale_dashboard = document.getElementById('sale-dashboard');
    const rent_dashboard = document.getElementById('rent-dashboard');

    $(search_bar).keyup(function(){
        var input = $(this).val();
        
        if (input != ""){
            $.ajax({
                url:"search_class.php",
                method:"POST",
                data:{input:input},
                success:function(data){
                    search_button.addEventListener("click", function(){
                        $(search_result).html(data).show();
                        $(sale_dashboard).css("display", "none");
                        $(rent_dashboard).css("display", "none");
                    }) 
                    
                }   
            });
        } else {
            
            $(search_result).css("display", "none");
        }
    });
});