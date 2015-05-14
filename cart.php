<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sliverado</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Sliverado,flim,cinema.movie,3D,dobly" />
	<meta name="description" content="movies of Website Sliverado" />
    <link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="stylesheet" type="text/css" href="cart.css" />
</head>

<body>
<?php include("header.php");?>
<script type="text/javascript" src="scripts/cart.js"></script>
<div id="logo">
	<h1>Sliverado</h1>
	<p>the Power of Cinema Series</p>
	<!--back ground image from http://www.sxjkgroup.com/wcm.files/upload/CMSsxjk/201404/201404081047033_b.jpg used as a banner -->
</div>
<div id="main">
<?php
if(!isset($_SESSION['screenings'])||count($_SESSION['screenings'])==0){
    echo "<h1 style='margin-left:20px;'>You have not yet pick up any orders :-D</h1>";
}
else{
    echo "<div id='shopping_cart'>";
    $total=0;
    foreach($_SESSION['screenings'] as $screening)
    {
       echo "<div class='order'>";
       
       echo "<input type='hidden' name='title' value='".$screening['title']."' />";
       echo "<input type='hidden' name='day'   value='".$screening['day']."'   />";
       echo "<input type='hidden' name='time'  value='".$screening['time']."'  />";
       
       echo "<h3>".$screening['title']."</h3>";
       echo "<p>Showing at <span>".$screening['day']." ,".$screening['time']."</span></p>";
       echo "<table><tr><td>Type</td><td>Seat</td><td>Price</td>";
       
       $subtotal=0;
       foreach($screening['seats'] as $num => $seat)
       {
           echo "<tr><td>".$num."</td>";
    	   if($seat['type']=="B")
    	   {
    	       echo "<td>Beanbag</td>";
    	   }
    	   else
    	   {
    	       echo "<td>".$seat['type']."</td>";
    	   }
    	   echo "<td>$".$seat['price']."</td></tr>";
    	   $subtotal+=$seat['price'];
       }
       echo "<tr><td></td><td>Subtotal:</td><td>$".$subtotal."</td></tr>";
       echo "</table><div class='delete_item'><a>Delete from Cart</a></div>";
	   echo "<input type='hidden' name='subtotal' value='".$subtotal."'>";
	   echo "</div>";
       $total+=$subtotal;
    }
	if(isset($_SESSION['voucher']))
	{
		$total=0.8*$total;
		echo "<p id='total'>Total: $".$total."</p>";
        echo "<input type='hidden' name='total' value='".$total."'>";
        echo "<p>Voucher Code:</p><input name='voucher' type='text' value='".$_SESSION['voucher']."' disabled/>";
	}
	else{
		echo "<p id='total'>Total: $".$total."</p>";
		echo "<input type='hidden' name='total' value='".$total."'>";
        echo "<p>Voucher Code:</p>       <input name='voucher' type='text' pattern='^\d{5}-\d{5}-[A-Z]{2}$' required /><input id='check_voucher' type='submit' value='APPLY'>";
    }
	echo "<input name='reset'  type='button' value='RESET'>";
    echo "<input name='checkout' type='button' value='CHECK OUT'>";
	echo "</div>";
}
?>
</div>
<?php
include("footer.php");
?>
</body>
</html>