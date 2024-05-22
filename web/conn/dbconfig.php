<?php 
$server="localhost";
$user="billing";
$pw="billing3322";
$db_name="billing";
$conn=@mysql_connect("$server","$user","$pw") or 
     die ("Unable to connect server! ".mysql_error());
$db=mysql_select_db($db_name,$conn) or 
    die ("Unable to connect database! ".mysql_error());
?>