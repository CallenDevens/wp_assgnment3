$(document).ready(function(){
    $("#cart").click(function(){
	   window.location= 'cart.php';
	});
	
	$("#order span").click(function(){
	    $("#orderform").slideToggle("fast");
	})
});