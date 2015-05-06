<!DOCTYPE html>
<html>
<head>
    <title>Sliverado</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Sliverado,flim,cinema.movie,3D,dobly" />
	<meta name="description" content="movies of Website Sliverado" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body onload="loadInfo()">
<script type="text/javascript" src="scripts/jquery-1.11.2.js"></script>
<script type="text/javascript" src="scripts/movie.js"></script>
<?php include("header.html");?>

<div id="postBar">
  <div id="postContainer">
    <button id="leftButton" onclick="moveLeft()">&lt;</button>
    <div class="post"><img src="images/poster_avengers.jpg" alt="averngers" /></div>
	<div class="post"><img src="images/poster_infernal_affairs.jpg" alt="infernal affairs" /></div>
	<div class="post"><img src="images/poster_looper.jpg" alt="loopers" /></div>
	<div class="post"><img src="images/poster_v.jpg" alt="V" /></div>
    <div class="post"><img src="images/poster_puss.jpg" alt="Puss in Boots" /></div>
    <div class="post"><img src="images/poster_gar.jpg" alt="Garfield" /></div>
    <button id="rightButton" onclick="moveRight()">&gt;</button>
  </div>
</div>

<div id="movieMenu">
 <div id="moviesShow">
   <div class="divHeader">MOIVE LIST</div>
  </div>
</div>
<?php
include("footer.php");
?>
</body>
</html>