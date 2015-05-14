<?php
$order_id=$_GET['id'];
$email=$_GET['email'];

include('connect.php');

$get_order=$connection->prepare('select cust_email,cust_moblie,cust_name,cust_name,total,voucher from orders where orderID=:order_id');
$get_orderline=$connection->prepare('select orderID,mvTitle,day,time,seat,type,price from orderline where orderID=:order_id');
$get_order->bindParam(':order_id',$order_id);
$get_orderline->bindParam(':order_id',$order_id);


?>