
<!DOCTYPE html>
<html>
<head>
    <title>Sliverado</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Sliverado,flim,cinema.movie,3D,dobly" />
	<meta name="description" content="movies of Website Sliverado" />
    <link rel="stylesheet" type="text/css" href="order.css" />
</head>

<body>
<?php
    //give an access to ajax
    echo "<input type='hidden' name='title' value='".$_GET['title']."' />";
	echo "<input type='hidden' name='day' value='".$_GET['day']."' />";
	echo "<input type='hidden' name='time' value='".$_GET['time']."'/>";
?>
<script type="text/javascript" src="scripts/jquery-1.11.2.js"></script>
<script type="text/javascript" src="scripts/order.js"></script>
<div id="container">
  <div id="picker">
      <h2>Confirm Your Tickets Here</h2>
	  
	  <p id="total">Total: $<span>0.00<span><p>
	  <button id="submit" onclick="addToCart()">SUBMIT</button>
  </div>
  
<div id="room">
  <div id="header"></div>
  <div id="front">Font Row. closest to Screens</div>
  <div id="pick_area">
<?php
include('connect.php');
//fetch price table from database;
$ticket_price=$connection->prepare('SELECT type, price from price WHERE day=:day AND time=:time');
$ticket_day=substr($_GET['day'],0,3);
$ticket_price->bindParam(':day',$ticket_day);
$ticket_price->bindParam(':time',$_GET['time']);
$ticket_price->execute();
while($price=$ticket_price->fetch(PDO::FETCH_ASSOC)){
    echo "<input type='hidden' id='".$price['type']."' name='price' value='".$price['price']."'>";
}

//fetch seat info from table
$display_seats=$connection->prepare('SELECT seat_number, state FROM seats WHERE mvTitle=:title AND day=:day AND time=:time');
$display_seats->bindParam(':title',$_GET['title']);
$display_seats->bindParam(':day', $_GET['day']);
$display_seats->bindParam(':time',$_GET['time']);
$display_seats->execute();
$result=$display_seats->fetch(PDO::FETCH_ASSOC);
$level=substr($result['seat_number'],0,1);

echo "<div class='column'><ul>";
if($result['state']=="0")
{
    echo "<li><input type='checkbox' id='".$result['seat_number']."' value='".$result['seat_number']."'>";
	echo "<label for='".$result['seat_number']."'><div class='seat_available'>".$result['seat_number']."</div></label></li>";}
else{
    echo "<li><div class='seat_unavailable'>".$result['seat_number']."</div></li>";
}
while($result=$display_seats->fetch(PDO::FETCH_ASSOC)){
    $seat_column=substr($result['seat_number'],0,1);
	$seat_row=intval(substr($result['seat_number'],1,2));
	
	if($seat_column==$level)
	{
	    if($result['state']=="0")
        {
		    if(in_array($seat_column,array("E","F","G","H"))&&$seat_row>5&&$seat_row<10)//Beanbag seat wider than normal ones
			{
	     		echo "<li><input type='checkbox' id='".$result['seat_number']."' value='".$result['seat_number']."'>";
				echo "<label for='".$result['seat_number']."'><div class='beanbag_available'>".$result['seat_number']."</div></label></li>";
			}
	        else{
	     		echo "<li><input type='checkbox' id='".$result['seat_number']."' value='".$result['seat_number']."'>";
				echo "<label for='".$result['seat_number']."'><div class='seat_available'>".$result['seat_number']."</div></label></li>";
            }
		}
		else{
    		if(in_array($seat_column,array("E","F","G","H"))&&$seat_row>5&&$seat_row<10)
			{
                 echo "<li><div class='beanbag_unavailable'>".$result['seat_number']."</div></li>";
			
			}
			else{
                 echo "<li><div class='seat_unavailable'>".$result['seat_number']."</div></li>";
			}
        }
	}
	else{
	    echo "</ul></div><div class='column'><ul>";
	    
		if($result['state']=="0")
        {
		    if(in_array($seat_column,array("E","F","G","H"))&&$seat_row>5&&$seat_row<10)//likely to be never executed...
			{
	     		echo "<li><input type='checkbox' id='".$result['seat_number']."' value='".$result['seat_number']."'>";
				echo "<label for='".$result['seat_number']."'><div class='beanbag_available'>".$result['seat_number']."</div></label></li>";
			}
			else
			{
			    echo "<li><input type='checkbox' id='".$result['seat_number']."' value='".$result['seat_number']."'>";
				echo "<label for='".$result['seat_number']."'><div class='seat_available'>".$result['seat_number']."</div></label></li>";
			}
		}
		else{
            echo "<li><div class='seat_unavailable'>".$result['seat_number']."</div></li>";
        }
		$level=substr($result['seat_number'],0,1);
	}
}

?>
  </div>
 
 </div>
 <div id="back" >Back Row. Furthest from Screen</div>
 <div id="example">
 <div class="example_wrap">
    <div class="example_seat" style="background-color:#858585;"></div><span>Available<span>
 </div>

  <div class="example_wrap">
    <div class='example_seat' style="background-color:#131211;"></div><span>Taken<span>
 </div>

 <div class="example_wrap">
   <div class='example_seat' style="background-color:#305f88;"></div><span>Your seat<span>
 </div>
</div>
</div>


</body>
</html>