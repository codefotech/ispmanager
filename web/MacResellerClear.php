<?php
extract($_POST);
include("conn/connection.php");

					$querydd = "DELETE FROM billing_mac WHERE z_id = '$z_id'";
					if(!mysql_query($querydd))
					{
						die('Error: ' . mysql_error());
					}
					
					$queryddsss = "DELETE FROM billing_mac_archive WHERE z_id = '$z_id'";
					if(!mysql_query($queryddsss))
					{
						die('Error: ' . mysql_error());
					}
					
					$query44 = "DELETE FROM billing_mac_client WHERE c_id IN (SELECT c_id FROM clients WHERE z_id = '$z_id')";
					if(!mysql_query($query44))
					{
						die('Error: ' . mysql_error());
					}
					
					$query44d = "DELETE FROM payment_mac_client WHERE c_id IN (SELECT c_id FROM clients WHERE z_id = '$z_id')";
					if(!mysql_query($query44d))
					{
						die('Error: ' . mysql_error());
					}

					$query1 = "DELETE FROM payment_macreseller WHERE z_id = '$z_id'";
					if (!mysql_query($query1))
					{
						die('Error: ' . mysql_error());

					}
					
					$query33 ="update emp_info set clear = '1' WHERE z_id = '$z_id'";
					$result = mysql_query($query33) or die("inser_query failed: " . mysql_error() . "<br />");

					echo 'clear done.';
?>

