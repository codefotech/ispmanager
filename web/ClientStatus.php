<?php
session_start();
include('company_info.php');
include("mk_api.php");
include('include/telegramapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$c_id = $_GET['id'];
extract($_POST); 
$ee_id = $_SESSION['SESS_EMP_ID'];
ini_alter('date.timezone','Asia/Almaty');
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());
$todayy = date('d', time()); //17
$lastdayofthismonth = date('t'); //31

$queeeee = mysql_query("SELECT breseller FROM clients WHERE c_id = '$c_id'");
$rowwee = mysql_fetch_assoc($queeeee);
$breseller = $rowwee['breseller'];

if($breseller == '1'){
$que = mysql_query("SELECT con_sts, mk_id, mac_user, breseller, raw_download, raw_upload, total_price, ip, mac FROM clients WHERE c_id = '$c_id'");
$row = mysql_fetch_assoc($que);
$adfgh = $row['con_sts'];
$pprice = $row['total_price'];
$macuser = $row['mac_user'];
$mk_id = $row['mk_id'];
$bresellerr = $row['breseller'];
$ip = $row['ip'];
$mac = $row['mac'];
$raw_download = $row['raw_download'];
$raw_upload = $row['raw_upload'];
$match = $raw_upload.''.'M/'.''.$raw_download.''.'M';
$maxlimit = '1k/1k';
}
else{
$que = mysql_query("SELECT c.con_sts, c.mk_id, c.p_id, c.mac_user, p.p_price FROM clients as c LEFT JOIN package as p ON p.p_id = c.p_id WHERE c.c_id = '$c_id'");
$row = mysql_fetch_assoc($que);
$adfgh = $row['con_sts'];
$pidd = $row['p_id'];
$pprice = $row['p_price'];
$macuser = $row['mac_user'];
$mk_id = $row['mk_id'];
}

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk = mysql_fetch_assoc($sqlmk);
$ServerIP = $rowmk['ServerIP'];
$Username = $rowmk['Username'];
$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
$Port = $rowmk['Port'];

		if($adfgh == 'Active'){
			if($ee_id != ''){
			$API = new routeros_api();
			$API->debug = false;
			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
				if($breseller == '1'){
					$API->write('/queue/simple/print', false);
					$API->write('?name='.$c_id);
					$res=$API->read(true);

					$arrID = $API->comm("/queue/simple/getall", 
							array(".proplist"=> ".id","?name" => $c_id,));

							$API->comm("/queue/simple/set",
							array(".id" => $arrID[0][".id"],"max-limit" => $maxlimit));
					$API->disconnect();
				$query = "UPDATE clients SET con_sts = 'Inactive', con_sts_date = '$update_date', bandwidth = '$match' WHERE c_id = '$c_id'";
				}
				else{
					$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_id,));
					if($inactive_way_sts == '0'){
							$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "yes",));
					}
					else{
							$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"profile" => "Inactive"));
					}
					
					$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_id,));
							$API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
					$API->disconnect();
				$query = "UPDATE clients SET con_sts = 'Inactive', con_sts_date = 'update_date', auto_sts = '0' WHERE c_id = '$c_id'";
				}
			if (!mysql_query($query)){ die('Error: ' . mysql_error()); }
			
				$query1 = "INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by, note) VALUES ('$c_id', 'Inactive', '$update_date', '$update_time', '$ee_id', '$note')";
			if (!mysql_query($query1))
					{
					die('Error: ' . mysql_error());
					}
					
			$query222 = "INSERT INTO emp_log (e_id, c_id, module_name, titel, date, time, action, action_details) VALUES ('$ee_id', '$c_id', 'Clients', 'Change_Client_Status', '$update_date', '$update_time', 'Inactive_Client', 'Inactive_a_Client')";
			if (!mysql_query($query222))
					{
					die('Error: ' . mysql_error());
					}

//-----------------Telegram-------------------------------
$sqlmqq = mysql_query("SELECT c.c_name, c.cell, e.`con_sts`, e.`update_date`, e.`update_time`, q.e_name AS updatebyy, e.`update_date_time`, e.note FROM con_sts_log AS e 
						LEFT JOIN emp_info AS q ON q.e_id = e.update_by
						LEFT JOIN clients AS c ON c.c_id = e.c_id
						WHERE e.c_id = '$c_id' ORDER BY e.id DESC LIMIT 1");
						
		$rowmkqq = mysql_fetch_assoc($sqlmqq);
		$cname = $rowmkqq['c_name'];
		$ccell = $rowmkqq['cell'];
		$update_datetime = $rowmkqq['update_date_time'];
		$updatebyy = $rowmkqq['updatebyy'];
		$noteeee = $rowmkqq['note'];

if($tele_sts == '0' && $tele_client_status_sts == '0'){
$telete_way = 'client_status';
$msg_body='..::[Client Deactivated]::..
'.$cname.' ['.$c_id.'] ['.$ccell.']

Note: '.$noteeee.'

at '.$update_datetime.'

By: '.$updatebyy.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}
//-----------------Telegram-------------------------------
					?>
			<html>
				<body>
				<form action="Clients?id=all" method="post" name="ok">
					<input type="hidden" name="sts" value="Status<?php echo $adfgh; ?>">
				</form>
				<script language="javascript" type="text/javascript">
					document.ok.submit();
				</script>
				</body>
			</html>
			
		<?php
		$API->disconnect();
		}
			else{ echo "Error!! No Connected Network Found.";}
		mysql_close($con);
		}
		else{}
		}
		else{?>
			<html>
				<body>
				<form action="ClientsInactive" method="post" name="ok">
					<input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
					<input type="hidden" name="ee_id" value="<?php echo $ee_id; ?>">
					<input type="hidden" name="note" value="<?php echo $note; ?>">
				</form>
				<script language="javascript" type="text/javascript">
					document.ok.submit();
				</script>
				</body>
			</html>
		<?php }

		mysql_close($con); ?>