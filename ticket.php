<?php
$order_id=$_GET['id'];
$email=$_GET['email'];

include('connect.php');

$get_order=$connection->prepare('select count(*) as num, cust_email,cust_moblie,cust_name,total,trim(voucher) as voucher from orders where orderID=:order_id');
$get_orderline=$connection->prepare('select orderID,mvTitle,day,time,seat,type,price from orderline where orderID=:order_id order by mvTitle,day,time');

$get_order->bindParam(':order_id',$order_id);
$get_orderline->bindParam(':order_id',$order_id);


?>
<!DOCTYPE html>
<html>
<head>
    <title>Sliverado Tickets</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Sliverado,flim,cinema.movie,3D,dobly" />
	<meta name="description" content="movies of Website Sliverado" />
	<link rel="stylesheet" type="text/css" href="ticket.css" />
</head>
<body>
<div id="order">
<?php
echo "<div class='ticket_head'>";
$get_order->execute();
$order_result=$get_order->fetch(PDO::FETCH_ASSOC);

if($order_result['num']!=1)
{
    die("database error..No data for your order");
}
echo "<table>";
echo "<tr><td>$order_id      </td><td>".$order_result['cust_email']."      </td></tr>";
echo "<tr><td>".stripslashes($order_result['cust_name'])."</td><td>".$order_result['cust_moblie']."</td></tr>";
echo "</table>";

$get_order_head=$connection->prepare('select mvTitle,day,time,type,count(*)  as quantity ,sum(price) as subtotal from orderline where orderID=:order_id  group by  mvTitle,day,time, type');
$get_order_head->bindParam(':order_id',$order_id);
$get_order_head->execute();

$result=$get_order_head->fetch(PDO::FETCH_ASSOC);

$title=$result['mvTitle'];
$day=$result['day'];
$time=$result['time'];

echo "<table>";
echo "<tr><th colspan='2'>".$result['mvTitle']."&nbsp;&nbsp;".$result['day']."&nbsp;".$result['time']."</th></tr>";
$title=$result['mvTitle'];
$day=$result['day'];
$time=$result['time'];

while($result=$get_order_head->fetch(PDO::FETCH_ASSOC))
if($title==$result['mvTitle']&&$day==$result['day']&&$time==$result['time'])
{
    echo "<tr><td>".$result['type']." &times; ".$result['quantity']."</td><td>".number_format((float)$result['subtotal'], 2, '.', '')."</td></tr>";
}
else
{
    echo "</table>";
	echo "<table>";
	echo "<tr><th colspan='2'>".$result['mvTitle']."&nbsp;&nbsp;".$result['day']."&nbsp;".$result['time']."</th></tr>";
    echo "<tr><td>".$result['type']." &times; ".$result['quantity']."</td><td>".number_format((float)$result['subtotal'], 2, '.', '')."</td></tr>";
    $title=$result['mvTitle'];
    $day=$result['day'];
    $time=$result['time'];
}
echo "</table>";

echo "<table>";
if(!empty($order_result['voucher']))
{
   echo "<tr><td>Voucher discount(20%)</td><td>".$order_result['voucher']."</td></tr>";
}
echo "<tr><td>Total:</td><td>".number_format((float)$order_result['total'], 2, '.', '')."</td></tr>";
echo "</table>";
echo "</div>";

$get_orderline->execute();
while($result=$get_orderline->fetch(PDO::FETCH_ASSOC))
{
   echo "<div class='ticket'>";
   echo "<p>THE SILVER CINEMA PRESENTS</p>";
   echo "<h1>".$result['mvTitle']."</h1>";
   
   echo "<table>";
   echo "<tr><th>TYPE</th><th>ROW</th><th>SEAT</th><tr>";
   echo "<tr><td>".$result['type']."</td><td>".substr($result['seat'],0,1)."</td><td>".substr($result['seat'],1)."</td></tr>";
   echo "<tr><th>PRICE</th><th>DAY</th><th>TIME</th><tr>";
   echo "<tr><td>$".number_format((float)$result['price'], 2, '.', '')."</td><td>".$result['day']."</td><td>".$result['time']."</td></tr>";
   echo "</table>";
   echo "<p class='tip'>YOU WERE SERVED BY SILVER.COM, TICKET REG:".$result['orderID']."</p>";
   echo "<p class='tip' >THE SILVER CINEMA.LTD</p>";
   echo "</div>";

}
?>
</body>
</html>