<?php
session_start();
$e_id = $_SESSION['SESS_EMP_ID'];
include("conn/connection.php");
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
date_default_timezone_set('Etc/GMT-6');
$delete_date_time = date('Y-m-d H:i:s', time());
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());
$todaydate = date('Y-m-d', time());
extract($_POST);

	$sqljjj = mysql_query("SELECT * FROM clients WHERE c_id = '$c_id'");
	$rowjj = mysql_fetch_assoc($sqljjj);
	$pid = $rowjj['p_id'];
	$mkid = $rowjj['mk_id'];
	$mac_user = $rowjj['mac_user'];
	$con_sts = $rowjj['con_sts'];
	
	$sqlbill = mysql_query("SELECT id FROM billing WHERE c_id = '$c_id' AND MONTH(bill_date) = MONTH('$todaydate') AND YEAR(bill_date) = YEAR('$todaydate')");
		$rowbill = mysql_fetch_assoc($sqlbill);
		$billid = $rowbill['id'];

	$sqlllll = mysql_query("SELECT * FROM login WHERE e_id = '$c_id'");
		$rowllll = mysql_fetch_assoc($sqlllll);
		
	$sqlpppp = mysql_query("SELECT * FROM package WHERE p_id = '$pid'");
		$rowlppp = mysql_fetch_assoc($sqlpppp);
		$pprice = $rowlppp['p_price'];

	$comment = $c_name.'-'.$cell.'-'.$address.'-'.$bname.'-'.$join_date.'-'.$pprice.'TK';

	$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mkid'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port']; 
		
								$API = new routeros_api();
								$API->debug = false;
								if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
									
								if($rowjj['breseller'] == '1'){
									 		$nombre =  $c_id;
											$target = $rowjj['ip'];
											$maxlimit= $rowjj['raw_upload'].''.'M/'.''.$rowjj['raw_download'].''.'M';
											$API->comm("/queue/simple/add", array(
											  "name"     => $nombre,
											  "target" => $target,
											  "max-limit"  => $maxlimit,
											));
								}else{
								   		$nombre =  $c_id;
										$password = $rowllll['pw'];;
										$service = 'pppoe';
										$profile = $rowlppp['mk_profile'];
										$API->comm("/ppp/secret/add", array(
										  "name"     => $nombre,
										  "password" => $password,
										  "profile"  => $profile,
										  "service"  => $service,
										  "comment"  => $comment,
										));
										
								}
								
								
		if($mac_user == '1'){
		if($con_sts == 'Active'){
					$arrID = $API->comm("/ppp/secret/getall", 
						  array(".proplist"=> ".id","?name" => $c_id,));

						$API->comm("/ppp/secret/set",
						array(".id" => $arrID[0][".id"],"disabled"  => "no",));
								$API->disconnect();
		}
		else{
					$arrID = $API->comm("/ppp/secret/getall", 
						array(".proplist"=> ".id","?name" => $c_id,));

						$API->comm("/ppp/secret/set",
						array(".id" => $arrID[0][".id"],"disabled"  => "yes",));
								$API->disconnect();

		}
		
		$query ="UPDATE clients SET sts = '0', con_sts = '$con_sts', delete_by = '$e_id' WHERE c_id = '$c_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$query1 ="UPDATE login SET status = '0', log_sts = '1' WHERE e_id = '$c_id'";
		$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
		}
		
		 else{
		$query ="UPDATE clients SET sts = '0', con_sts = 'Active', delete_by = '$e_id' WHERE c_id = '$c_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$query22220 = "INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by) VALUES ('$c_id', 'Active', '$update_date', '$update_time', '$e_id')";
				if (!mysql_query($query22220)){
					die('Error: ' . mysql_error());
				}
				
		if($billid == ''){
			$query2222 = "INSERT INTO billing (c_id, bill_date, p_id, p_price, discount, bill_amount) VALUES ('$c_id', '$todaydate', '$pid', '$pprice', '0.00', '$pprice')";
				if (!mysql_query($query2222)){
					die('Error: ' . mysql_error());
				}
			
		}else{}
		
		$query1 ="UPDATE login SET status = '0', log_sts = '0' WHERE e_id = '$c_id'";
		$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
		}
		
				$action_details = 'Client ID: '.$c_id.' has been restored.';
				$query222e = "INSERT INTO emp_log (e_id, c_id, module_name, titel, date, time, action, action_details) VALUES ('$e_id', '$c_id', 'Clients', 'Restore', '$update_date', '$update_time', 'Restore_Client', '$action_details')";
				if (!mysql_query($query222e)){	die('Error: ' . mysql_error());	}
				if ($result1)
					{ 
				
				echo '<script type="text/javascript">window.close()</script>';
				
						 }
				else
					{
						echo 'Error Code 102';
					}
								$API->disconnect();

								}
								else
{ 
	echo "Error!! No Connected Network Found.";
} 

mysql_close($con);
?>