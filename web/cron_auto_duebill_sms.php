<?php
include("conn/connection.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');

$send_date = date("Y-m-d");
$send_time = date("h:i a");
$month = date("M", time()); 
$send_by= $e_id;

$sqlsdf = mysql_query("SELECT sms_msg, from_page FROM sms_msg WHERE id= '3'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];

			$sql = mysql_query("SELECT t.c_id, c.c_name, c.cell, c.z_id, (t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00)) AS paybleamount, c.payment_deadline, c.mk_id FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
								WHERE t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.mac_user = '0' AND c.con_sts = 'Active' AND c.sts = '0'");


	while( $row = mysql_fetch_assoc($sql) ){
//	$from_page = 'SMS Due Bills';

	$c_idd = $row['c_id'];
	$c_name = $row['c_name'];
	$cell = $row['cell'];
	$paybleamount = $row['paybleamount'];
	$payment_deadline = $row['payment_deadline'];
	
	$replacements = array(
	'c_id' => $c_idd,
	'c_name' => $c_name,
	'c_deadline' => $payment_deadline,
	'comp_name' => $comp_name,
	'company_cell' => $company_cell,
	'month' => $month,
	'total_due' => $paybleamount
	);
	
$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}

function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}
?>
