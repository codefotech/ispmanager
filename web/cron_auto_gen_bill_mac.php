<?php
include("conn/connection.php");
include('company_info.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');

$gen_date = date('Y-m-d', time());
$bill_date_time = date('Y-m-d H:i:s', time());
$month = date("M", time()); 

	$sql = mysql_query("SELECT c.c_id, c.c_name, c.termination_date, c.z_id, p.p_price_reseller AS p_price, c.breseller, c.total_price, c.discount, c.extra_bill, c.p_id, c.con_sts, c.cell FROM clients AS c LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.sts = '0' AND c.mac_user = '1'");
	while( $row = mysql_fetch_assoc($sql) ){
		
		
		$c_id = $row['c_id'];
		$c_idd = $row['c_id'];
		$c_name = $row['c_name'];
		$status = $row['con_sts'];
		$breseller = $row['breseller'];
		$z_id = $row['z_id'];
		$termination_datedd = date('jS F, Y', strtotime($row['termination_date']));

if($breseller == '0'){
		if($status == 'Active'){
			$p_id = $row['p_id'];
			$p_price = $row['p_price'];
			$discount = $row['discount'];
			$extra_bill = $row['extra_bill'];
			
			$bill_amount = ($p_price - $discount) + $extra_bill;
			
			$sql88 = ("SELECT s.id, s.link, s.username, s.password, s.status, e.e_name, e.e_cont_per FROM sms_setup AS s LEFT JOIN emp_info AS e ON e.z_id = s.z_id WHERE s.status = '0' AND s.z_id = '$z_id'");
			$query88 = mysql_query($sql88);
			$row88 = mysql_fetch_assoc($query88);
					$link= $row88['link'];
					$username= $row88['username'];
					$password= $row88['password'];
					$reseller_namedd= $row88['e_name'];
					$reseller_celldd= $row88['e_cont_per'];
					
			if($username != ''){
				$sqlsdf = mysql_query("SELECT sms_msg, from_page, send_sts FROM sms_msg WHERE z_id = '$z_id' AND from_page = 'Generate Bill'");
				$rowsm = mysql_fetch_assoc($sqlsdf);
				
				$sms_msg= $rowsm['sms_msg'];
				$from_page= $rowsm['from_page'];
				$send_sts= $rowsm['send_sts'];
			}
			else{
				$sms_msg= '';
				$from_page= '';
				$send_sts= '1';
			}
		}
		if($status == 'Inactive'){
			$p_id = $row['p_id'];
			$p_price = 0;
			$discount = 0;
			$extra_bill = 0;
			$bill_amount = 0;
			$sms_msg= '';
			$from_page= '';
			$send_sts= '1';
		}
}
else{
		if($status == 'Active'){
			$p_id = 0;
			$p_price = $row['total_price'];
			$discount = $row['discount'];
			$extra_bill = $row['extra_bill'];
			
			$bill_amount = ($p_price - $discount) + $extra_bill;
		}
		if($status == 'Inactive'){
			$p_id = 0;
			$p_price = 0;
			$discount = 0;
			$extra_bill = 0;
			$bill_amount = 0;
		}
}
		$sql1 = mysql_query("SELECT COUNT(id) AS cnt FROM billing_mac_client WHERE c_id = '$c_id' AND DATE_FORMAT(bill_date, '%Y-%m') = DATE_FORMAT('$gen_date', '%Y-%m')");
		$row1 = mysql_fetch_assoc($sql1);
		$count = $row1['cnt'];

		if($count == 0){
			$query2ff = mysql_query("insert into billing_mac_client (c_id, bill_date, bill_date_time, p_id, p_price, discount, bill_amount, extra_bill) VALUES ('$c_id', '$gen_date', '$bill_date_time', '$p_id', '$p_price', '$discount', '$bill_amount', '$extra_bill')");
	
			$res = mysql_query("SELECT l.amt, t.dic, t.pay, l.p_price, l.p_name, l.bandwith, l.cell, l.mac_user FROM
					(
						SELECT b.c_id, SUM(b.bill_amount) AS amt, b.p_price, p.p_name_reseller AS p_name, p.bandwith, c.cell, c.mac_user FROM billing_mac_client AS b LEFT JOIN package AS p ON p.p_id = b.p_id LEFT JOIN clients AS c ON c.c_id = b.c_id WHERE b.c_id = '$c_id' AND c.mac_user = '1'
					)l
					LEFT JOIN
					(
						SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment_mac_client WHERE c_id = '$c_id'
					)t
					ON l.c_id = t.c_id");

			$rows = mysql_fetch_array($res);
			$Dew = 	$rows['amt'] - ($rows['pay'] + $rows['dic']);

			$pprice = $rows['p_price'];
			$pname = $rows['p_name'];
			$bandwith = $rows['bandwith'];
			$cell = $rows['cell'];
			$mac_userz = $rows['mac_user'];
//			$cell = (int) filter_var($cell1z, FILTER_SANITIZE_NUMBER_INT);
			
			
if($send_sts == '0'){
	$replacements = array(
	'c_id' => $c_idd,
	'c_name' => $c_name,
	'termination_date' => $termination_datedd,
	'TotalDue' => $Dew,
	'ThisMonth' => $month,
	'MonthBillAmount' => $bill_amount,
	'MonthDiscountAmount' => $discount,
	'reseller_name' => $reseller_namedd,
	'reseller_cell' => $reseller_celldd,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);
$send_by = 'Auto';
$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
		}}
	}

function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

?>