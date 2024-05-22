<?php
include("conn/connection.php");
include('company_info.php');

include('include/smsapi.php');
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');

$auto_inactive_date_time = date('Y-m-d H:i:s', time());	
$update_date = date('Y-m-d', time());
$todayyyy = date('Y-m-d', time());
$todayyyy_time = date('H:i:s', time());
$update_time = date('H:i:s', time());

			$sql = mysql_query("SELECT c.c_id, c.c_name, c.cell, c.termination_date, c.z_id, e.e_name AS empname, IFNULL(e.auto_recharge, 0) AS auto_recharge, e.minimum_day, c.p_id, p.p_price, c.mac_user, e.e_cont_per, c.mk_id, c.mac_user FROM clients AS c
LEFT JOIN zone AS z ON z.z_id = c.z_id
LEFT JOIN emp_info AS e ON e.e_id = z.e_id
LEFT JOIN package AS p ON p.p_id = c.p_id
								WHERE c.con_sts = 'Active' AND c.termination_date <= '$update_date'  AND c.termination_date != '0000-00-00'");
								
	while( $row = mysql_fetch_assoc($sql) ){
		
	$from_page = 'Terminated';
	$mkk_id = $row['mk_id'];
	$c_idd = $row['c_id'];
	$z_id = $row['z_id'];
	$c_name = $row['c_name'];
	$cell1w = $row['cell'];
	$auto_recharge = $row['auto_recharge'];
	$minimum_day = $row['minimum_day'];
	$p_id = $row['p_id'];
	$p_price = $row['p_price'];
	$termination_date = $row['termination_date'];
	
	$cell = (int) filter_var($cell1w, FILTER_SANITIZE_NUMBER_INT);
	$empname = $row['empname'];
	$mac_userr = $row['mac_user'];
	$e_cont_per = $row['e_cont_per'];
	
if($auto_recharge == '0'){
	$note = 'Terminated at '.$auto_inactive_date_time.'';
	$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mkk_id'");
	while( $rowmk = mysql_fetch_assoc($sqlmk) ){

			$ServerIP = $rowmk['ServerIP'];
			$Username = $rowmk['Username'];
			$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
			$Port = $rowmk['Port'];
			
			$API = new routeros_api();
			$API->debug = false;
	if($API->connect($ServerIP, $Username, $Pass, $Port)) {
				$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_idd,));
				if($inactive_way_sts == '0'){
							$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "yes",));
					}
					else{
							$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "no","profile" => "Inactive"));
					}
						
				$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_idd,));
						$API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
						
			$query = "UPDATE clients SET con_sts = 'Inactive', termination_note = '$note', auto_inactive_date_time = '$auto_inactive_date_time', con_sts_date = '$update_date' WHERE c_id = '$c_idd'";
			if (!mysql_query($query))
					{
					die('Error: ' . mysql_error());
					}
			$query1 = "INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by ) VALUES ('$c_idd', 'Inactive', '$update_date', '$update_time', 'Auto')";
			if (!mysql_query($query1))
					{
					die('Error: ' . mysql_error());
					}

if($mac_userr != '1'){
$sms_body = 'Dear '.$c_idd.',
Your account has been Terminated.
Please contact us for re-active the connection.

Thanks
'.$comp_name.'
'.$company_cell.'';

		
$send_by = 'Auto';
include('include/smsapicore.php');
}
}//MK_Con

	
	}//MK
	
	}
if($auto_recharge == '1'){
	$note = 'Auto recharged at '.$auto_inactive_date_time.' for '.$minimum_day.' days';
	$new_termination_date = date('Y-m-d', strtotime($todayyyy . " + ".$minimum_day." day"));
	$packageoneday = $p_price/30;
	$daycost = $minimum_day*$packageoneday;
	
	$queryq ="UPDATE clients SET p_id = '$p_id', termination_date = '$new_termination_date', termination_note = '$note', con_sts_date = '$update_date' WHERE c_id = '$c_idd'";
	if (!mysql_query($queryq))
							{
							die('Error: ' . mysql_error());
							}
	$query2bb = "INSERT INTO billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time) VALUES ('$c_idd', '$z_id', '$p_id', '$todayyyy', '$todayyyy_time', '$new_termination_date', '$minimum_day', '$p_price', '$daycost', 'Auto_Recharged', '$update_date', '$update_time')";
	if (!mysql_query($query2bb))
							{
							die('Error: ' . mysql_error());
							}
}
	
	}//Main Loop
//header("Location:cron_auto_termination_remainder1.php");
$curlss = curl_init();
$urlff = $weblink.'cron_auto_termination_remainder1.php';
curl_setopt($curlss, CURLOPT_URL, $urlff);
curl_setopt($curlss, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt($curlss, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlss, CURLOPT_TIMEOUT, 10000); 
$resp = curl_exec($curlss);
curl_close($curlss);

echo $resp;

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

