<?php
session_start();

$title=$_GET['title'];
$day=$_GET['day'];
$time=$_GET['time'];

include('connect.php');

if(strcmp($title,"all")==0){
    $reset_tickets=$connection->prepare('update seats set state="0" where mvTitle=:title AND day=:day AND time=:time AND seat_number=:seat_number');
    foreach($_SESSION['screenings'] as $index => $screening){
	    
		$reset_tickets->bindParam(':title',$screening['title']);
	    $reset_tickets->bindParam(':day',$screening['day']);
	    $reset_tickets->bindParam(':time',$screening['time']);
		
        foreach($screening['seats'] as $type => $seat){
            //echo "type:".$type;
            $reset_tickets->bindParam(':seat_number',$type);
    	    $reset_tickets->execute();
    	    error_reporting(E_ALL);
    	}
    }
   unset($_SESSION['screenings']);
   unset($_SESSION['voucher']);
}
else
{
    //update ticket state in database
    $update_tickets=$connection->prepare('update seats set state="0" where mvTitle=:title AND day=:day AND time=:time AND seat_number=:seat_number');
    $update_tickets->bindParam(':title',$title);
    $update_tickets->bindParam(':day'  ,$day  );
    $update_tickets->bindParam(':time' ,$time );
    foreach($_SESSION['screenings'] as $index => $screening){
        if($screening['title']==$title&&$screening['day']==$day&&$screening['time']==$time)
    	{
            foreach($screening['seats'] as $type => $seat){
                //echo "type:".$type;
                $update_tickets->bindParam(':seat_number',$type);
    	        $update_tickets->execute();
    	        error_reporting(E_ALL);
            }
            unset($_SESSION['screenings'][$index]);
            break;
    	}
    }
}
?>