<?php
session_start();

$screening=$_POST['screening'];
$screening_data=json_decode($screening,true);
//print_r($screening_data);

if(empty($_SESSION['screenings'])){
   //the first element;
   $_SESSION['screenings'][]=$screening_data;
}
else if(is_array($_SESSION['screenings']))
{
    //flag state :
    //1 :the film order (the same title day time has already exists in $_SESSION['screenings'])
    //0 :the film order is not in $_SESSION['screenings'] yet.
    $insert_flag=0; 
    foreach($_SESSION['screenings'] as $orderline)
    {
         //If the film order exists in the  cart, add it into $_SESSION['screenings']'s seats
         if($screening_data['title']==$orderline['title']
		    &&$screening_data['day']==$orderline['day']
    	    &&$screening_data['time']==$orderline['time'])
    	 {
    	     $orderline['seats']=array_merge((array)$orderline['seats'],(array)$screening_data['seats']);
			 $insert_flag=1;
    		 break;
    	 }    
    }
	if($insert_flag==0){
	       $_SESSION['screenings'][]=$screening_data;
	}
}
/*
include('connect.php');  //update ticket state in database
$update_tickets=$connection->prepare('update seats set state="1" where mvTitle=:title AND day=:day AND time=:time AND seat_number=:seat_number');
$update_tickets->bindParam(':title',$screening_data->title);
$update_tickets->bindParam(':day',$screening_data->day);
$update_tickets->bindParam(':time',$screening_data->time);

foreach((array)($screening_data->seats) as $type => $seat){
    //echo "type:".$type;
    $update_tickets->bindParam('seat_number',$type);
	$update_tickets->execute();
	error_reporting(E_ALL);
}
*/

print_r($_SESSION['screenings']);
//session_unset();


?>