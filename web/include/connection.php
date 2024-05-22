<?php
$server = "localhost";
$user = "asthatecnet_el1";
$pass = "Online_123456";
$dbname = "asthatecnet_el1";
$con = @mysql_connect($server, $user, $pass);
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
$qqq = mysql_select_db($dbname, $con);
?>