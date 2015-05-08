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
<div id="shopping_cart">
<?php
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
   echo "</table><div class='delete_item'><a>Delete from Cart</a></div></div>";
   $total+=$subtotal;
}
echo "<p>Total:".$total."</p>";
?>
</div>

<div id="customer_information">
  <form action="POST" method="">
    <p>Voucher Code:</p>       <input type="text" pattern="^\d{5}-\d{5}-[A-Z]{2}$" required />
    <p>Email:</p>              <input type="text" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.([A-Za-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$" required />
    <p>MobliePhone number:</p> <input type="text" pattern="^|\+614|04|\s?(\d){4}\s?(\d){4}$" required />
	<input type="submit" value="submit" />
  
  </form>

</div>
</div>
<?php
include("footer.php");
?>
</body>
</html>