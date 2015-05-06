var ticket_num=0;
$(document).ready(function(){
    $("input[type='checkbox']").change(function(){
        if(ticket_num<10){
            if($(this).prop("checked"))
            {
                $(this).next().children().css("background-color","#305f88");
                var type=$(this).val();
                //test
                //console.log("seat type:"+type);
                selectTicketType(type);
				ticket_num++;
            }
            else
            {
               $(this).next().children().css("background-color","#858585");
            }
        }
    });
});
function selectTicketType(type)
{
    ticket=document.createElement("div");
    ticket.className="orderline";
    switch(type.substring(0,1))
    {
        case "E":
        case "F":
        case "G":
        case "H":
           //test
           //console.log("seat number:"+type.substring(1,3));

           if(parseInt(type.substring(1,3))>5&&parseInt(type.substring(1,3))<10)
           {
               var price_B=$("input[name='price'][id='B']").val();
               ticket.innerHTML="<p>"+type+"</p><input type='radio' value='B' id='"+type+"B' name='"+type+"' checked='checked'/><label><div>Beanbag</div></label>";
               ticket.innerHTML+="<span class='price'>$"+price_B+"</span>"
               $(ticket).insertBefore("p#total");
               $("input[name='"+type+"']").next().children().css({
                    "background-color":"#2E4E7E",
                     "color":"#FFFFF0"
               });

               var total=parseFloat($("p#total span").html());
               total+=parseFloat(price_B);
               $("p#total span").html(parseFloat(total).toFixed(2));
           }
           else
           {
                ticket.innerHTML+="<p>"+type+"</p><input type='radio' value='SA' id='"+type+"SA' name='"+type+"'/><label for='"+type+"SA'><div>Full</div></label>";
                ticket.innerHTML+="<input type='radio' value='SP' id='"+type+"SP' name='"+type+"'/><label for='"+type+"SP'><div>Conc</div></label>";
                ticket.innerHTML+="<input type='radio' value='SC' id='"+type+"SC' name='"+type+"'/><label for='"+type+"SC'><div>Child</div></label><span class='price'></span>";
                $(ticket).insertBefore("p#total");
                $("input[name='"+type+"']").change(function(){
                $("input[name='"+type+"']").next().children().css({
                    "background-color":"#FFFFF0",
                    "color":"#66665E"});
                $(this).next().children().css({
                    "background-color":"#2E4E7E",
                     "color":"#FFFFF0"
                });
            });
           }


           break;
        case "A":
        case "B":
        case "C":
        case "D":
                ticket.innerHTML+="<p>"+type+"</p><input type='radio' value='FA' id='"+type+"FA' name='"+type+"'/><label for='"+type+"FA'><div>Adult</div></label>";
             ticket.innerHTML+="<input type='radio' value='FC' id='"+type+"FC' name='"+type+"'/><label for='"+type+"FC'><div>Child</div></label><span class='price'></span>";
             $(ticket).insertBefore("p#total");
             $("input[name='"+type+"']").change(function(){
                $("input[name='"+type+"']").next().children().css({
                    "background-color":"#FFFFF0",
                    "color":"#66665E"});
                $(this).next().children().css({
                    "background-color":"#2E4E7E",
                     "color":"#FFFFF0"
                 });
            });
    }
	
	//calculate total
    $("input[name='"+type+"']").change(function(){
         var price_id=$(this).val();
         var price=$("input[name='price'][id='"+price_id+"']").val();
         $(this).parent().children("span.price").html("$"+parseFloat(price).toFixed(2));

         var total=0;
         $("span.price").each(function(){
             var item=$(this).html();
                 if(item!=""){
                     total+=parseFloat(item.substring(1));
                 }
         });
         $("p#total span").html(parseFloat(total).toFixed(2));
    });

//rebind cancel event
//note :bind would not recover old version event. 
	$("input[type='checkbox']").change(function(){
        if(ticket_num<10){
            if($(this).prop("checked"))
            {
            }
            else
            {
			   var type=$(this).val();
			   //test
			   console.log("type:"+type);
			   $(".orderline input[type='radio'][name='"+type+"']").parent().hide(function(){
			       $(this).remove()
			   });
               $(this).next().children().css("background-color","#858585");
            }
        }
    });
	
	
}
function addToCart(){
//verify
    if($(".orderline input[type='radio']:checked").length != $(".orderline").length){
	    //test 
//		console.log("input:"+$(".orderline input[type='radio']:checked").length);
//		console.log("orderline:"+$(".orderline").length);	
//		alert("error!");

		return;
	}

	    //test 
//		console.log("input:"+$(".orderline input[type='radio']:checked").length);
//		console.log("orderline:"+$(".orderline").length);
			
	
	
    var title = $("input[type='hidden'][name='title']").val();
    var day   = $("input[type='hidden'][name='day']").val();
    var time  = $("input[type='hidden'][name='time']").val();

//organize data structure
    var dataObject={};   //dataObject :screenings in $_SESSION
    dataObject['title'] = title;
    dataObject['day']   = day;
    dataObject['time']  = time;

	var seats={};
    $(".orderline").each(function(){
	    var seat= {};
        var seat_number = $(this).children("input[type='radio']:checked").attr("name");
		var ticket_type = $(this).children("input[type='radio']:checked").val();
		var ticket_price= $(this).children("span").text().substring(1);
		
		seat['type']   = ticket_type;
		seat['price']  = ticket_price;
		
//		console.log("number:"+seat_number);
//		console.log("type:"+ticket_type);
//		console.log("price:"+ticket_price);	
		seats[seat_number]=seat;
    });
	//console.log(seats);

	dataObject['seats']=seats;
	
    //console.log(dataObject);
	//convert to JSON
	var jsonData=JSON.stringify(dataObject);
	//console.log(jsonData);
	
    var request = $.ajax({
        url: "addcart.php",
        method: "POST",
        data: {"screening": jsonData},
		dataType:"json",
		complete: function(){
			alert("complete!");
		}
    });
}