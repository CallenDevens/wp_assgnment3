<?php 
session_start();
include('connect.php');

/*
SA = Standard Adult
SP = Standard Concession
SC = Standard Child
FA = First Class Adult
FC = First Class Child
B1 = Beanbag, one lonely person :'-(
B2 = Beanbag, up to 2 people
B3 = Beanbag, up to 3 children
*/
function typeConvert($type)
{
    switch($type)
	{
	    case "SA":
		   return "Standard Adult";
		case "SP":
		   return "Standard Concession";
        case "SC": 
		   return "Standard Child";
		case "FA":
		   return "First Class Adult";
		case "FC":
		    return "First Class Child";
		case "B":
		    return "Beanbag";
		default:
		    return "";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sliverado</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Sliverado,flim,cinema.movie,3D,dobly" />
	<meta name="description" content="movies of Website Sliverado" />
    <link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="stylesheet" type="text/css" href="checkout.css" />
</head>

<body>
<?php include("header.php");?>
<script type="text/javascript" src="scripts/checkout.js"></script>
<div id="logo">
	<h1>Sliverado</h1>
	<p>the Power of Cinema Series</p>
	<!--back ground image from http://www.sxjkgroup.com/wcm.files/upload/CMSsxjk/201404/201404081047033_b.jpg used as a banner -->
</div>

<?php 
if(isset($_POST['email'])&&isset($_POST['telenum'])&&isset($_POST['name']))
{
    $email=$_POST['email'];
    $telenum=$_POST['telenum'];
    $name=$_POST['name'];
    
	echo "<fieldset>";
    echo "<legend>Check out</legend>";

	echo "<div id='response'>";
	echo "<h2>".$name."</h2>";

	$order_id=time()."-".rand(1000,9999);
    $insert_order=$connection->prepare('insert into orders (orderID,cust_email,cust_moblie,cust_name,total,voucher)values(:order_id,:cust_email,:cust_moblie,:cust_name,:total,:voucher)');
    $insert_orderline=$connection->prepare('insert into orderline(orderID,mvTitle,day,time,seat,type,price) values(:order_id,:title,:day,:time,:seat,:type,:price)');

	$insert_order->bindParam(':order_id',$order_id);
	$insert_orderline->bindParam(':order_id',$order_id);
	
	$total=0.00;
    foreach($_SESSION['screenings'] as $index => $screening){
	    
		$insert_orderline->bindParam(':title',$screening['title']);
	    $insert_orderline->bindParam(':day',$screening['day']);
	    $insert_orderline->bindParam(':time',$screening['time']);
		
        foreach($screening['seats'] as $num => $seat){
		
            //echo "type:".$type;
            $type=typeConvert($seat['type']);
			
			$insert_orderline->bindParam(':seat',$num);
			$insert_orderline->bindParam(':type',$type);
			$insert_orderline->bindParam(':price',$seat['price']);
    	    $insert_orderline->execute();
    	    error_reporting(E_ALL);
			
			$total+=$seat['price'];
    	}
    }
	
	if(isset($_SESSION['voucher'])&&!empty($_SESSION['voucher']))
	{
	    $total=$total*0.8;
		$insert_order->bindParam(':voucher',$_SESSION['voucher']);

	}
	
	if(!get_magic_quotes_gpc())
	{
	    $name=addslashes($name);
	    $email=addslashes($email);
		$telenum=addslashes($telenum);
	}
	$insert_order->bindParam(':cust_name',$name);
	$insert_order->bindParam(':cust_email',$email);
	$insert_order->bindParam(':cust_moblie',$telenum);
	$insert_order->bindParam(':total',$total);
	$insert_order->bindParam(':voucher',$_SESSION['voucher']);

	$insert_order->execute();
	error_reporting(E_ALL);

//	$insert_order->debugDumpParams();

	
    session_unset();
	echo "<p>You have sent out your order.</p>";

	echo "<table>";
	echo "<tr><td><p>Order Number:</p></td><td><span>".$order_id."</span></td></tr>";
    echo "<tr><td><p>Email:       </p></td><td><span>".$email."   </span></td></tr>";
	echo "<tr><td><p>Moblie:      </p></td><td><span>".$telenum." </span></td></tr>";
    echo "</table>";
	
	echo "<a class='button' onclick=popitup('ticket.php?id=".$order_id."&email=".$email."') >view printable tickets</a>";
	echo "</div>";
	echo "</fieldset>";
}
else
{ 
	echo "<fieldset>";
    echo "<legend>Check out</legend>";

    echo "<div id='customer_information'>";

    echo " <form action='checkout.php' method='POST'>";
    echo "<h3>Email:</h3><input type='text' name='email' pattern='^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.([A-Za-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$' required />";
    echo "<p>used to check your tickets :-D</p>";
	
	echo "<h3>MobliePhone number:</h3> <input type='text' name='telenum' pattern='^(\+614|04|\(04\))(\s|-)?(\d){4}(\s|-)?(\d){4}$' required />";
	echo "<p> Australian mobile number: begins with +614 or (04) or 04 </p>";
    echo "<h3>Name:</h3> <input type='text' name='name' pattern='^[A-Za-z\s']{1,}[\.]{0,1}[A-Za-z\s']{0,}$' required />";

    echo "	<input type='submit' value='submit' />";
    echo " </form>";
    echo "</div>";
		echo "</fieldset>";

}

?>
<?php
include('footer.php');
?>
</body>

</html>