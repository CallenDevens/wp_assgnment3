<?php

// these lines will show all errors (never do this in a live environment!)
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(E_ALL);

$dbFile = 'sliver.db';

// create a connection to the SQLite DB file using PDO
$connection = new PDO('sqlite:' . $dbFile);
// throw exceptions when there is an error
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// return db rows as objects
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
   
?>