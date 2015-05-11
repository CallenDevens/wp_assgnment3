$(document).ready(function(){
    $(".delete_item").click(function(){

    	var title=$(this).parent().children("input[type='hidden'][name='title']").val();
		var day=$(this).parent().children("input[type='hidden'][name='day']").val();
		var time=$(this).parent().children("input[type='hidden'][name='time']").val();
		
		var subtotal=$(this).parent().children("input[type='hidden'][name='subtotal']").val();
		
		$.ajax({
		    type:"GET",
			url:"removecart.php?title="+title+"&day="+day+"&time="+time,
			context:this,
			success:function(){
			     $(this).parent().hide("fast",function(){
				     $(this).remove();

					 var total=parseFloat($("input[type='hidden'][name='total']").val());
					 total=total-subtotal;
					 console.log("total:"+total)
					 $("input[type='hidden'][name='total']").val(total);
				     $("#total").text("Total:$"+total);
				 });
			}
		});
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
					 //console.log("total:"+total)
					 $("input[type='hidden'][name='total']").val(total);
				     $("#total").text("Total:$"+total);
					 
					 $("input[type='text'][name=voucher]").attr('disabled','disabled');
					 $(this).attr('disabled','disabled');
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
			     alert("success!");
			}
		});
	});
	
});