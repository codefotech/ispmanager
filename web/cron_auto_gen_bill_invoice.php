<?php
include("conn/connection.php");
include('company_info.php');

include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');

$sqlsdf = mysql_query("SELECT sms_msg, from_page, send_sts FROM sms_msg WHERE id= '11'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];
$send_sts= $rowsm['send_sts'];

$gen_date = date('Y-m-d', time());
$fst_daaate = date('Y-m-01', time());
$last_daaate = date('Y-m-t', time());
$lastday = date('t', time());
$bill_date_time = date('Y-m-d H:i:s', time());
$month = date("M", time()); 

$sql = mysql_query("SELECT c_id, c_name, com_id, invoice_date, due_deadline, total_price, con_sts, cell, sts FROM clients WHERE breseller = '2'");
while( $row = mysql_fetch_assoc($sql) ){
		
		$c_id = $row['c_id'];
		$c_name = $row['c_name'];
		$com_id = $row['com_id'];
		$con_sts = $row['con_sts'];
		$invoice_date = $row['invoice_date'];
		$due_deadline = $row['due_deadline'];
		$total_price = $row['total_price'];
		$cell = $row['cell'];
		$delete_sts = $row['sts'];
		
		$sql1 = mysql_query("SELECT COUNT(id) AS cnt FROM billing_invoice WHERE c_id = '$c_id' AND DATE_FORMAT(invoice_date, '%Y-%m') = DATE_FORMAT('$gen_date', '%Y-%m') AND sts = '0'");
		$row1 = mysql_fetch_assoc($sql1);
		$count = $row1['cnt'];

	if($count == '0'){
 		$y = date('y', time());
		$m = date('m', time());
		$ss = date('s', time());
		$datffff = $y.$m.$ss;
		
		$due_deadlinee = $y.'-'.$m.'-'.$due_deadline;
		$querydd2 = mysql_query("SELECT invoice_id FROM billing_invoice ORDER BY invoice_id DESC LIMIT 1");
		$rowdd = mysql_fetch_assoc($querydd2);
		$old_idddd = $rowdd['invoice_id'];
		
		if($old_idddd == ''){
			$invoice_id_new = $datffff + 100;
		}
		else{
			$invoice_id_new = $old_idddd + 1;
		}
		
		$queryinv2 = "SELECT id, item_id, item_name, description, quantity, unit, uniteprice, vat, days, total_price FROM monthly_invoice WHERE c_id = '$c_id' AND sts = '0'";
		if ($con_sts != 'Active') {
			$queryinv2 .= " ORDER BY id ASC LIMIT 1";
		}
			
		$queryinv22 = mysql_query($queryinv2);
			
		while($inv = mysql_fetch_assoc($queryinv22)) {
					
			$item_id = $inv['item_id'];
			$item_name = $inv['item_name'];
			$description = $inv['description'];
			$unit = $inv['unit'];
				
			if ($con_sts != 'Active') {
				$quantity = '0.00';
				$uniteprice = '0.00';
				$vat = '0.00';
				$total_price = '0.00';
			}
			else{
				$quantity = $inv['quantity'];
				$uniteprice = $inv['uniteprice'];
				$vat = $inv['vat'];
				$total_price = $inv['total_price'];
			}
			
			$sqlsin = ("INSERT INTO billing_invoice (invoice_id, invoice_date, c_id, item_id, item_name, description, quantity, unit, uniteprice, vat, start_date, end_date, days, total_price, due_deadline) 
				VALUES ('$invoice_id_new', '$fst_daaate', '$c_id', '$item_id', '$item_name', '$description', '$quantity', '$unit', '$uniteprice', '$vat', '$fst_daaate', '$last_daaate', '$lastday', '$total_price', '$due_deadlinee')");
				
			$resulsff = mysql_query($sqlsin) or die("inser_query failed: " . mysql_error() . "<br />");
		}
		
		$res = mysql_query("SELECT IFNULL((b.bill - p.paid), '0.00') AS total_due FROM clients AS c 
							LEFT JOIN
							(SELECT IFNULL(c_id, '$c_id') AS c_id, IFNULL(SUM(total_price), '0.00') AS bill FROM billing_invoice WHERE sts = '0' AND c_id = '$c_id')b
							ON b.c_id = c.c_id
							LEFT JOIN
							(SELECT IFNULL(c_id, '$c_id') AS c_id, IFNULL((SUM(pay_amount)+SUM(bill_discount)), '0.00') AS paid FROM payment WHERE sts = '0' AND c_id = '$c_id')p
							ON p.c_id = c.c_id
							WHERE c.breseller = '2' AND c.c_id = '$c_id' AND c.con_sts = 'Active' AND c.sts = '0'");

			$rows = mysql_fetch_array($res);
			$total_due = $rows['total_due'];
			
if($send_sts == '0' && $delete_sts == '0' && $con_sts == 'Active'){
/* 	$replacements = array(
	'c_id' => $c_id,
	'c_name' => $c_name,
	'com_id' => $com_id,
	'TotalDue' => $total_due,
	'ThisMonth' => $month,
	'billing_deadline' => $b_date,
	'MonthBillAmount' => $bill_amount,
	'MonthDiscountAmount' => $discount,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);
	
$sms_body = bind_to_template($replacements, $sms_msg);
$c_idd = $c_id;
$send_by = 'Auto';
include('include/smsapicore.php'); */
}
}
}

mysql_close($con);
	
function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

?>