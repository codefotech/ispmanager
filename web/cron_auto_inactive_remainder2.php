<?php
include("conn/connection.php");
include('company_info.php');

include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');
$this_month = date("M", time()); 
//$deadline = date('d',strtotime("+1 days"));

$send_date = date('Y-m-d', time());
$send_time = date('H:i:s', time());

$sqlsdf = mysql_query("SELECT sms_msg, from_page, send_sts, day FROM sms_msg WHERE id= '13'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];
$send_sts= $rowsm['send_sts'];
$day= $rowsm['day'];

$deadline = date('d',strtotime("+".$day." days"));

			$sql = mysql_query("SELECT t.c_id, c.c_name, c.com_id, c.cell, (t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00)) AS totdueclients, c.payment_deadline, c.mk_id FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
WHERE t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.payment_deadline != '' AND c.mac_user = '0' AND c.con_sts = 'Active' AND c.payment_deadline = '$deadline'");
								
	while( $row = mysql_fetch_assoc($sql) ){
		
//	$from_page = '2nd Rimainder';
	$mkk_id = $row['mk_id'];
	$c_idd = $row['c_id'];
	$c_name = $row['c_name'];
	$com_id = $row['com_id'];
	$cell = $row['cell'];
	$payment_deadline = $row['payment_deadline'];
	$totdueclients = $row['totdueclients'];

if($send_sts == '0'){
	$replacements = array(
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'c_name' => $c_name,
	'c_deadline' => $payment_deadline,
	'this_month' => $this_month,
	'TotalDue' => $totdueclients,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);
	
$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}
	}
	
function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

?>

