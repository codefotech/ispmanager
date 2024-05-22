<?php
include("conn/connection.php");
extract($_POST); 
ini_alter('date.timezone','Asia/Almaty');
$checked_date_time = date('Y-m-d H:i:s', time());

		$query ="UPDATE payment SET checked = '1', checked_by = '$checked_by', checked_date_time = '$checked_date_time' WHERE id = '$checked'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

if($result){
echo '<script type="text/javascript">window.close()</script>';
 }
else
{
	echo 'Error Code 101';
}

mysql_close($con);
?>