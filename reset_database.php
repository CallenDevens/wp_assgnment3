<?php
include('connect.php');
//update ticket state in database
$update_tickets=$connection->prepare('update seats set state="0"');
$update_tickets->execute();
error_reporting(E_ALL);

echo "database reset!";
?>