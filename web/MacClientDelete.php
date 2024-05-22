<?php
include("conn/connection.php");
$c_id = $_GET['id'];
		

			$query = "DELETE FROM clients WHERE c_id = '$c_id'";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
			if ($result)
			{
				$query1 = "DELETE FROM login WHERE e_id = '$c_id'";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");

			}
			
			if ($result)
			{
				$query2 = "DELETE FROM con_sts_log WHERE c_id = '$c_id'";
				$result2 = mysql_query($query2) or die("inser_query failed: " . mysql_error() . "<br />");

			}
			if ($result)
			{
				$query3 = "DELETE FROM package_change WHERE c_id = '$c_id'";
				$result3 = mysql_query($query3) or die("inser_query failed: " . mysql_error() . "<br />");

			}
			if ($result)
			{
				$query4 = "DELETE FROM payment WHERE c_id = '$c_id'";
				$result4 = mysql_query($query4) or die("inser_query failed: " . mysql_error() . "<br />");

			}
			
			if ($result)
			{
				$query5 = "DELETE FROM billing WHERE c_id = '$c_id'";
				$result5 = mysql_query($query5) or die("inser_query failed: " . mysql_error() . "<br />");

			}
			if ($result)
			{
				echo 'Delete done from clients...';
			}

			if ($result1)
			{
				echo 'Delete done from login...';
			}
			if ($result2)
			{
				echo 'Delete done from con_sts_log...';
			}

			if ($result3)
			{
				echo 'Delete done from package_change...';
			}
			if ($result4)
			{
				echo 'Delete done from payment...';
			}

			if ($result5)
			{
				echo '<script type="text/javascript">window.close()</script>';
			}
?>

