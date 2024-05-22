<?php
include("conn/connection.php");
extract($_POST);
if($user_type == 'admin' || $user_type == 'superadmin'){
					$query = "DELETE FROM clients WHERE c_id = '$c_id'";
					if(!mysql_query($query))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '01. clients: Done<br>';}

					$query1 = "DELETE FROM login WHERE e_id = '$c_id'";
					if (!mysql_query($query1))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '02. login: Done<br>';}
					
					$query2 = "DELETE FROM con_sts_log WHERE c_id = '$c_id'";
						if (!mysql_query($query2))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '03. con_sts_log: Done<br>';}
				
					$query3 = "DELETE FROM package_change WHERE c_id = '$c_id'";
					if (!mysql_query($query3))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '04. package_change: Done<br>';}
					
					$query4 = "DELETE FROM payment WHERE c_id = '$c_id'";
					if (!mysql_query($query4))
					{
					die('Error: ' . mysql_error());
					}
					else{echo '05. payment: Done<br>';}

					$query6 = "DELETE FROM bill_signup WHERE c_id = '$c_id'";
					if (!mysql_query($query6))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '06. bill_signup: Done<br>';}
					
					$query7 = "DELETE FROM complain_master WHERE c_id = '$c_id'";
						if (!mysql_query($query7))
					{
					die('Error: ' . mysql_error());
					}
					else{echo '07. complain_master: Done<br>';}
					
					$query9 = "DELETE FROM sms_send WHERE c_id = '$c_id'";
					if (!mysql_query($query9))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '08. sms_send: Done<br>';}
					
					$query10 = "DELETE FROM billing WHERE c_id = '$c_id'";
					if (!mysql_query($query10))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '09. billing: Done<br>';}
					
					$query11 = "DELETE FROM billing_mac WHERE c_id = '$c_id'";
					if (!mysql_query($query11))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '10. billing_mac: Done<br>';}
					
					
					$query12 = "DELETE FROM billing_mac_client WHERE c_id = '$c_id'";
					if (!mysql_query($query12))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '11. billing_mac_client: Done<br>';}
					
					$query44d = "DELETE FROM payment_mac_client WHERE c_id = '$c_id'";
					if(!mysql_query($query44d))
					{
						die('Error: ' . mysql_error());
					}
					else{echo '12. payment_mac_client: Done<br>';}
					
					echo '<br>Delete Success!! Permanent delete from database. There are no way to get it back.';
}
else{
	echo 'Invalid Access.';
}
?>
<br>
<br>
<br>
<button onclick="history.back()">GO BACK</a>