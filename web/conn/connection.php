<?php
$server = "localhost";
$user = "billing";
$pass = "billing3322";
$dbname = "billing";
$con = @mysql_connect($server, $user, $pass);
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
$qqq = mysql_select_db($dbname, $con);
?>