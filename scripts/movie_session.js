var ticket;
$(document).ready(function(){
    $(".side ul li div").hover(function(){
        ticket=$(this).html();
    	$(this).html("Buy Now");
    	
    },function(){
        $(this).html(ticket);
    });
})