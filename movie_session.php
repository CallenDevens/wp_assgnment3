<?php
session_start();

$title=$_GET['title'];
include('connect.php');

$select_seats = $connection->prepare('SELECT * FROM seats WHERE mvTitle=:title AND day=:day AND time=:time AND state="0"');
$select_seats->bindParam(':title',$title);     
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sliverado</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Sliverado,flim,cinema.movie,3D,dobly" />
	<meta name="description" content="movies of Website Sliverado" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

<script type="text/javascript" src="scripts/jquery-1.11.2.js"></script>
<script type="text/javascript" src="scripts/movie_session.js"></script>
<?php include("header.html");?>

<div id="logo">
	<h1>Sliverado</h1>
	<p>the Power of Cinema Series</p>
	<!--back ground image from http://www.sxjkgroup.com/wcm.files/upload/CMSsxjk/201404/201404081047033_b.jpg used as a banner -->
</div>

<div id="main">
<?php
$jsonurl = "http://titan.csit.rmit.edu.au/~e54061/wp/movie-service.php";
$json = file_get_contents($jsonurl,0,null,null);
$json_output = json_decode($json);
//print_r($json_output);

foreach ( $json_output as $film )
{
    if($film->title==$title){
	   echo "<div class='movie_info'><img class='poster' src='$film->poster'></img>";
	   echo "<div id='description'><h1>$film->title</h1>";
	   foreach($film->description as $desc){
	       echo "<p>$desc</p>";
	   }
	   echo "</div></div>";
	  
	   echo "<div class='side'>";
	   echo "<h2>Show Time</h2><ul>";
       while(list($day,$time)=each($film->sessions))
	   {
	       echo "<li><span>$day</span><p>$time</p>";
		   
		   $select_seats->bindParam(':day',$day);
           $select_seats->bindParam(':time',$time);		   
		   $select_seats->execute();
		   $remain=count($select_seats->fetchAll());
		   if($remain>0){
		       echo "<div onclick=\"location.href='order.php?title=$title&day=$day&time=$time'\">Available:".$remain."</div></a>";
		   }
		   else{
		       echo "<div class='unavailable'>unavailable</div>";
		   }
		   
		   echo "</li>" ;
	   }
	   echo "</ul></div>";
	}

}
?>
</div>

<?php
   $connection=null;
   include('footer.php');

?>