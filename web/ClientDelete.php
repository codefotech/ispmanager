<?php
include("conn/connection.php");
include('include/hader.php');
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
date_default_timezone_set('Etc/GMT-6');
$delete_date_time = date('Y-m-d H:i:s', time());
$delete_date = date('Y-m-d', time());
$delete_time = date('H:i:s', time());
extract($_POST);

		$sqljjj = mysql_query("SELECT c_id, mk_id, breseller FROM clients WHERE c_id = '$c_id'");
		$rowjj = mysql_fetch_assoc($sqljjj);
		$mk_id = $rowjj['mk_id'];
		$breseller = $rowjj['breseller'];

	$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port']; 
		
								$API = new routeros_api();
								$API->debug = false;
								if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
									
								if($breseller == '1'){
									 $arrID =	$API->comm("/queue/simple/getall", 
											  array(".proplist"=> ".id","?name" => $c_id,));

											$API->comm("/queue/simple/remove",
												array(".id" => $arrID[0][".id"],));	
									$API->disconnect();
								}else{
								   $arrID =	$API->comm("/ppp/secret/getall", 
												array(".proplist"=> ".id","?name" => $c_id,));
											$API->comm("/ppp/secret/remove",
												array(".id" => $arrID[0][".id"],));	
												
									$arrID = $API->comm("/ppp/active/print",
												array(".proplist"=> ".id","?name" => $c_id,));

											$API->comm("/ppp/active/remove",
												array(".id" => $arrID[0][".id"],));
									$API->disconnect();
								}
								
		$query ="UPDATE clients SET sts = '1', delete_date_time = '$delete_date_time', con_sts = 'Inactive', delete_by = '$e_id' WHERE c_id = '$c_id'";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
				$query1 ="UPDATE login SET status = '1', log_sts = '1', delete_date_time = '$delete_date_time', delete_by = '$e_id' WHERE e_id = '$c_id'";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
				
				$action_details = 'Client ID: '.$c_id.' has been deleted.';
				$query222e = "INSERT INTO emp_log (e_id, c_id, module_name, titel, date, time, action, action_details) VALUES ('$e_id', '$c_id', 'Clients', 'Delete', '$delete_date', '$delete_time', 'Delete_Client', '$action_details')";
				if (!mysql_query($query222e)){	die('Error: ' . mysql_error());	}
				if ($result1)
					{ ?>
						<html>
							<body>
							<form action="Clients?id=all" method="post" name="ok">
								<input type="hidden" name="sts" value="delete">
							</form>
							<script language="javascript" type="text/javascript">
								document.ok.submit();
							</script>
							</body>
						</html>
					<?php }
				else
					{
						echo 'Error Code 102';
					}
			}
		else
			{
				echo 'Error Code 101';
			}
								}
								else
{ 
	echo "Error!! No Connected Network Found.";
} 

mysql_close($con);
?>
<br>
<h2>Processing... Please wait....</h2>