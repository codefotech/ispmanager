<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$id = $_GET['id'];

		$query ="UPDATE billing SET sts = '1' WHERE id = '$id'";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
				header('Location: Billing');
			}
		else
			{
				echo 'Error Code 101';
			}

mysql_close($con);
?>