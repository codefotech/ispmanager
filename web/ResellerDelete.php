<?php
extract($_POST);
include("conn/connection.php");

					$query = "DELETE FROM emp_info WHERE e_id = '$e_id'";
					if(!mysql_query($query))
					{
						die('Error: ' . mysql_error());
					}

					$query1 = "DELETE FROM login WHERE e_id = '$e_id'";
					if (!mysql_query($query1))
					{
						die('Error: ' . mysql_error());
					}
					
					$query1dsf = "DELETE FROM emp_log WHERE e_id = '$e_id'";
					if (!mysql_query($query1dsf))
					{
						die('Error: ' . mysql_error());
					}
					
					$query1ds = "DELETE FROM sms_setup WHERE z_id = '$z_id'";
					if (!mysql_query($query1ds))
					{
						die('Error: ' . mysql_error());
					}
					
					$quersssf = "DELETE FROM sms_send WHERE send_by = '$e_id'";
					if (!mysql_query($quersssf))
					{
						die('Error: ' . mysql_error());
					}
					
					$quersssfdss = "DELETE FROM sms_msg WHERE z_id = '$z_id'";
					if (!mysql_query($quersssfdss))
					{
						die('Error: ' . mysql_error());
					}

					$query1996 = "DELETE FROM login WHERE e_id IN (SELECT c_id AS e_id FROM clients WHERE z_id = '$z_id')";
					if (!mysql_query($query1996))
					{
						die('Error: ' . mysql_error());
					}
					
					$query2 = "DELETE FROM con_sts_log WHERE c_id IN (SELECT c_id FROM clients WHERE z_id = '$z_id')";
						if (!mysql_query($query2))
					{
						die('Error: ' . mysql_error());
					}
				
					$query3 = "DELETE FROM package_change WHERE c_id IN (SELECT c_id FROM clients WHERE z_id = '$z_id')";
					if (!mysql_query($query3))
					{
						die('Error: ' . mysql_error());
					}
					
					$query4 = "DELETE FROM payment_macreseller WHERE z_id = '$z_id'";
					if (!mysql_query($query4))
					{
					die('Error: ' . mysql_error());
					}

					$query6 = "DELETE FROM package WHERE z_id = '$z_id'";
					if (!mysql_query($query6))
					{
						die('Error: ' . mysql_error());
					}
					
					$query7 = "DELETE FROM complain_master WHERE c_id IN (SELECT c_id FROM clients WHERE z_id = '$z_id')";
						if (!mysql_query($query7))
					{
					die('Error: ' . mysql_error());
					}
					
					$query8 = "DELETE FROM billing WHERE c_id IN (SELECT c_id FROM clients WHERE z_id = '$z_id')";
					if (!mysql_query($query8))
					{
						die('Error: ' . mysql_error());
					}
					
					$query9 = "DELETE FROM zone WHERE z_id = '$z_id'";
					if (!mysql_query($query9))
					{
						die('Error: ' . mysql_error());
					}
					
					$query199 = "DELETE FROM clients WHERE z_id = '$z_id'";
					if (!mysql_query($query199))
					{
						die('Error: ' . mysql_error());
					}
					echo 'Delete Success!! Permanently deleted from database. There are no way to get it back.';
					
//					echo '<script type="text/javascript">window.close()</script>';
			
?>

