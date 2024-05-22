<?php
include("conn/connection.php");
extract($_GET);

$aaa = '{lat:'.$lat.',lng:'.$lon.'}';
$query2q ="insert into live_location (location) VALUES ('$aaa')";
					if (!mysql_query($query2q))
					{
					die('Error: ' . mysql_error());
					}
mysql_close($con);

echo $lat;
?>

