<?php
include("conn/connection.php");
include('include/telegramapi.php');
include('company_info.php');
include('include/smsapi.php');
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');

$auto_inactive_date_time = date('Y-m-d H:i:s', time());	
$deadline = date('d', time());
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());
$maxlimit = '1k/1k';

$sqlsdf = mysql_query("SELECT sms_msg, from_page, send_sts, accpt_amount FROM sms_msg WHERE id= '2'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];
$send_sts= $rowsm['send_sts'];
$accpt_amount= $rowsm['accpt_amount'];

			$sql = mysql_query("SELECT t.c_id, c.c_name, c.com_id, c.cell, (t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00)) AS totdueclients, c.payment_deadline, c.mk_id, c.breseller, c.ip, c.mac, c.raw_download, c.raw_upload FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c ON c.c_id = t.c_id
								WHERE t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '$accpt_amount' AND c.payment_deadline != '' AND c.mac_user = '0' AND c.con_sts = 'Active' AND c.payment_deadline = '02'");
								
	while( $row = mysql_fetch_assoc($sql) ){
		
	$mkk_id = $row['mk_id'];
	$c_idd = $row['c_id'];
	$com_id = $row['com_id'];
	$c_name = $row['c_name'];
	$cell = $row['cell'];
	$payment_deadline = $row['payment_deadline'];
	$breseller = $row['breseller'];
	$ip = $row['ip'];
	$mac = $row['mac'];
	$raw_download = $row['raw_download'];
	$raw_upload = $row['raw_upload'];
	$match = $raw_upload.''.'M/'.''.$raw_download.''.'M';
	$totdueclients = $row['totdueclients'];
	$note = $auto_inactive_date_time.' for Due Amount: '.$totdueclients.'TK.';

	$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mkk_id'");
	$rowmk = mysql_fetch_assoc($sqlmk);
				
	$ServerIP = $rowmk['ServerIP'];
	$Username = $rowmk['Username'];
	$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
	$Port = $rowmk['Port'];
			
	$API = new routeros_api();
	$API->debug = false;
			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
				if($breseller == '1')
				{
					$API->write('/queue/simple/print', false);
						$API->write('?name='.$c_idd);
						$res=$API->read(true);
						
				$arrID = $API->comm("/queue/simple/getall", 
						array(".proplist"=> ".id","?name" => $c_idd,));

						$API->comm("/queue/simple/set",
						array(".id" => $arrID[0][".id"],"max-limit" => $maxlimit));
				
				$query = "UPDATE clients SET con_sts = 'Inactive', note_auto = '$note', auto_sts = '1', auto_inactive_date_time = '$auto_inactive_date_time', bandwidth = '$match' WHERE c_id = '$c_idd'";
				}
				else{
				$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_idd,));
				if($inactive_way_sts == '0'){
							$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "yes",));
					}
					else{
							$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"profile" => "Inactive"));
					}
						
				$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_idd,));
						$API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
						
				$query = "UPDATE clients SET con_sts = 'Inactive', note_auto = '$note', auto_sts = '1', auto_inactive_date_time = '$auto_inactive_date_time', con_sts_date = '$update_date' WHERE c_id = '$c_idd'";
				}
				if (!mysql_query($query)){ die('Error: ' . mysql_error()); }
			$API->disconnect();
			
					$query1 = "INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by, auto_bue_bill) VALUES ('$c_idd', 'Inactive', '$update_date', '$update_time', 'Auto', '$totdueclients')";
					if (!mysql_query($query1)){die('Error: ' . mysql_error());}
			$mkstsnow = '';
			}
			else{
				if($breseller == '0'){
					$query = "UPDATE clients SET con_sts = 'Inactive', note_auto = '$note', auto_sts = '1', auto_inactive_date_time = '$auto_inactive_date_time', con_sts_date = '$update_date' WHERE c_id = '$c_idd'";
					if (!mysql_query($query)){ die('Error: ' . mysql_error());}
					
					$query1 = "INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by, auto_bue_bill) VALUES ('$c_idd', 'Inactive', '$update_date', '$update_time', 'Auto', '$totdueclients')";
					if (!mysql_query($query1)){die('Error: ' . mysql_error());}
			$mkstsnow = '<br>[Please Sync When Mikrotik is Connected.]';
				}
			}
	
if($send_sts == '0'){
	$replacements = array(
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'c_name' => $c_name,
	'c_deadline' => $payment_deadline,
	'company_name' => $comp_name,
	'company_cell' => $company_cell,
	'total_due' => $totdueclients);
	
$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}

//-----------------Telegram-------------------------------

if($tele_sts == '0' && $tele_client_status_sts == '0'){
$telete_way = 'client_status';
$msg_body='..::[Client Deactivated]::..
'.$c_name.' ['.$c_idd.'] ['.$cell.']

Note: '.$note.' '.$mkstsnow.'

..::Auto Inactivated:..
'.$tele_footer.'';

include('include/telegramapicore.php');
}

//-----------------Telegram-------------------------------
		
	}
	
function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

$sql8b8 = ("SELECT id, link, username, password, status FROM sms_setup WHERE status = '0' AND z_id = ''");
$quedry88 = mysql_query($sql8b8);
$rodw88 = mysql_fetch_assoc($quedry88);
$linkk = $rodw88['link'];

if($linkk == 'http://217.172.190.215/') {
	
$curls = curl_init();
$urlff = $weblink.'sms_deliverey_report.php?api_id=checkall';
curl_setopt($curls, CURLOPT_URL, $urlff);
curl_setopt($curls, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt($curls, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curls, CURLOPT_TIMEOUT, 10000); 
$respw = curl_exec($curls);
curl_close($curls);
}
?>

