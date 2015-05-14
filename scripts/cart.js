$(document).ready(function(){
    //detele item
	//delete items in session
	//recalculate total
    $(".delete_item").click(function(){
    	var title=$(this).parent().children("input[type='hidden'][name='title']").val();
		var day=$(this).parent().children("input[type='hidden'][name='day']").val();
		var time=$(this).parent().children("input[type='hidden'][name='time']").val();
		
		var subtotal=$(this).parent().children("input[type='hidden'][name='subtotal']").val();
		var voucher=$("input[name='voucher']").val();
		
		if($(".order").length>1){
		    $.ajax({
		        type:"GET",
		    	url:"removecart.php?title="+title+"&day="+day+"&time="+time,
		    	context:this,
		    	success:function(){
		    	     $(this).parent().hide("fast",function(){
		    		      $(this).remove();
            
		    			  var total=parseFloat($("input[type='hidden'][name='total']").val());
		    			  if(voucher=="")
		    			  {
		    			     total=total-subtotal;
		    			  }
		    			  else
		    			  {
		    			      total=total-0.8*subtotal;
		    			  }
		    			  $("input[type='hidden'][name='total']").val(total.toFixed(2));
		    		      $("#total").text("Total:$"+total.toFixed(2));
		    		 });
		    	}
		    });
	   }
	   else
	   {
	       $.ajax({
	     	    type:"GET",
	     		url:"removecart.php?title=all",
	     		success:function(){
	     		     $("#shopping_cart").hide(function(){
	     			     $(this).remove();
	     			 });
	     			 $("#main").html("<h1 style='margin-left:20px;'>You have not yet pick up any orders :-D</h1>");
	     		}
	     	});
	   
	   }
	});
	
	
	$("#check_voucher").click(function(){
    	var voucher=$("input[name='voucher']").val();
		$.ajax({
		    type:"POST",
			traditional: true,
			url:"check_voucher.php",
			data:{voucher:voucher},
			dataType: "html",
			context:this,
			success:function(data){
                 if(data.indexOf(true)>-1)
		         { 
				     var total=parseFloat($("input[type='hidden'][name='total']").val());
					 total=total*0.8;
					 console.log("total:"+total)
					 $("input[type='hidden'][name='total']").val(total.toFixed(2));
				     $("#total").text("Total:$"+total.toFixed(2));
					 
					 $("input[type='text'][name=voucher]").attr('disabled','disabled');
					 $(this).attr('disabled','disabled');
				 }
				 else
				 {
				      alert("INVALID VOUVHER!");
				 }
			}
		});
	});
    
	$("input[name='reset']").click(function(){
	    $.ajax({
		    type:"GET",
			url:"removecart.php?title=all",
			context:this,
			success:function(){
			     $(this).parent().hide(function(){
				     $(this).remove();
				 });
				 $("#main").html("<h1 style='margin-left:20px;'>You have not yet pick up any orders :-D</h1>");
			}
		});
	});
	
	
	$("input[name='checkout'][type='button']").click(function(){
	    document.location.href = "checkout.php";
	});
	
});