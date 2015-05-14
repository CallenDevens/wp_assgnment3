<?php
session_start();

$voucher=$_POST['voucher'];
if(isset($voucher))
{
    list($code1,$code2,$str)=explode("-",$voucher);
    if(chkCode($code1,substr($str,0,1))&&chkCode($code2,substr($str,1,1)))
    {
		$_SESSION['voucher']=$voucher;
		//print_r($_SESSION['screenings']);
		//print_r($_SESSION);
        echo "true";
    }
    else{
       echo "false";
    }
}
else{
	unset($_SESSION['voucher']);
}
function chkCode($num, $char){
    $num1=(int)substr($num,0,1);
    $num2=(int)substr($num,1,1);
    $num3=(int)substr($num,2,1);
    $num4=(int)substr($num,3,1);
    $num5=(int)substr($num,4,1);
	
//ASC2 code A=65 Z=90
//verify code A=0 Z=25

    $chk_asc=(($num1*$num2+$num3)*$num4+$num5)%26;
//	echo '$chk_asc:'.$chk_asc."    ";
	if($chk_asc+65==ord($char))
	{
	    return true;
	}
	else
	{
	    return false;
	}
        
}
?>