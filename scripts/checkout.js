$(document).ready(function(){
    $("input[type='button'][value='SAVE']").click(function(){
	    var email=$("input[type='text'][name='email']").val();
		var name=$("input[type='text'][name='name']").val();
		var phone=$("input[type='text'][name='telenum']").val();
		
		$.ajax({
		   type:"POST",
		   url:"customer_info.php",
		   data:{action:"save",email:email,name:name,phone:phone}
		});
	});
	
	$("input[type='button'][value='RESET']").click(function(){		
		$.ajax({
		   type:"POST",
		   url:"customer_info.php",
		   data:{action:"reset"},
		   success:function(){
		        $("input[type='text'][name='email']").val('');
		        $("input[type='text'][name='name']").val('');
		        $("input[type='text'][name='telenum']").val('');
		   }
		});
	});
}); 
 function popitup(url)
    {
       newwindow=window.open(url,'tickets','height=1000,width=450');
       if (window.focus) {newwindow.focus()}
       return false;
    }