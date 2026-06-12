$(document).ready(function(){
    // Move these INSIDE the ready function so they don't crash
    const search_bar = document.getElementById("search_bar");
    const search_result = document.getElementById("search-results");
    
    // Grab the dashboards so we can hide them during a search
    const sale_dashboard = document.getElementById('sale-dashboard');
    const rent_dashboard = document.getElementById('rent-dashboard');

    $(search_bar).keyup(function(){
        var input = $(this).val();
        
        if (input != ""){
            // User is typing a search!
            $.ajax({
                url:"search_class.php",
                method:"POST",
                data:{input:input},
                success:function(data){ 
                    // Show search results
                    $(search_result).html(data).show();
                    
                    // Hide the main dashboards so they don't overlap
                    $(sale_dashboard).hide();
                    $(rent_dashboard).hide();
                }   
            });
        } else {
            // Search bar is empty!
            
            // 1. Hide the search results
            $(search_result).hide();

            // 2. We need to turn the dashboards back on. 
            // The easiest way is to trick JS 1 into thinking we just clicked the radio button again!
            const checkedRadio = document.querySelector('input[name="property_status"]:checked');
            if (checkedRadio) {
                // This triggers your `changeInfo()` function from JS 1 automatically
                checkedRadio.dispatchEvent(new Event('change')); 
            }
        }
    });
});