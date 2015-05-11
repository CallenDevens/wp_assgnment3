var ticket;
$(document).ready(function(){
    $(".side ul li div").hover(function(){
        ticket=$(this).html();
    	$(this).html("Buy Now");
    	
    },function(){
        $(this).html(ticket);
    });
})
function popitup(url)
{
   newwindow=window.open(url,'order','height=700,width=1300');
   if (window.focus) {newwindow.focus()}
   return false;
}