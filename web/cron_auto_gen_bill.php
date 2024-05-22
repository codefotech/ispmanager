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
$bill_date_time = date('Y-m-d H:i:s', time());
$month = date("M", time()); 

	$sql = mysql_query("SELECT c.c_id, c.c_name, c.com_id, c.extra_bill, p.p_price, c.payment_deadline, c.b_date, c.breseller, c.total_price, c.discount, c.p_id, c.con_sts, c.cell, c.sts FROM clients AS c LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.mac_user = '0' AND c.breseller != '2'");
	while( $row = mysql_fetch_assoc($sql) ){
		
		$c_id = $row['c_id'];
		$c_name = $row['c_name'];
		$com_id = $row['com_id'];
		$status = $row['con_sts'];
		$breseller = $row['breseller'];
		$payment_deadline = $row['payment_deadline'];
		$b_date = $row['b_date'];
		$delete_sts = $row['sts'];
		
if($breseller == '0'){
		if($status == 'Active'){
			$p_id = $row['p_id'];
			$p_price = $row['p_price'];
			$discount = $row['discount'];
			$extra_bill = $row['extra_bill'];
			
			$bill_amount = ($p_price - $discount) + $extra_bill;

		}
		if($status == 'Inactive'){
			$p_id = $row['p_id'];
			$p_price = 0;
			$discount = 0;
			$bill_amount = 0;
			$extra_bill = 0;
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
		$sql1 = mysql_query("SELECT COUNT(id) AS cnt FROM billing WHERE c_id = '$c_id' AND DATE_FORMAT(bill_date, '%Y-%m') = DATE_FORMAT('$gen_date', '%Y-%m')");
		$row1 = mysql_fetch_assoc($sql1);
		$count = $row1['cnt'];

		if($count == 0){
			$query2 = mysql_query("insert into billing (c_id, bill_date, bill_date_time, p_id, p_price, discount, extra_bill, bill_amount) VALUES ('$c_id', '$gen_date', '$bill_date_time', '$p_id', '$p_price', '$discount', '$extra_bill', '$bill_amount')");
//			$from_page = 'Generate Bill';
	
			$res = mysql_query("SELECT l.amt, t.dic, t.pay, l.p_price, l.p_name, l.bandwith, l.cell, l.mac_user FROM
					(
						SELECT b.c_id, SUM(b.bill_amount) AS amt, b.p_price, p.p_name, p.bandwith, c.cell, c.mac_user FROM billing AS b	LEFT JOIN package AS p ON p.p_id = b.p_id LEFT JOIN clients AS c ON c.c_id = b.c_id WHERE b.c_id = '$c_id' AND c.mac_user = '0' AND c.con_sts = 'Active'
					)l
					LEFT JOIN
					(
						SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment WHERE c_id = '$c_id'
					)t
					ON l.c_id = t.c_id");

			$rows = mysql_fetch_array($res);
			$Dew = 	$rows['amt'] - ($rows['pay'] + $rows['dic']);

			$pprice = $rows['p_price'];
			$pname = $rows['p_name'];
			$bandwith = $rows['bandwith'];
			$cell1z = $rows['cell'];
			$cell = (int) filter_var($cell1z, FILTER_SANITIZE_NUMBER_INT);
			$mac_userz = $rows['mac_user'];

if($send_sts == '0' && $delete_sts == '0'){
	$replacements = array(
	'c_id' => $c_id,
	'c_name' => $c_name,
	'com_id' => $com_id,
	'TotalDue' => $Dew,
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
include('include/smsapicore.php');
}
}
else{
			//echo 'No Bill Generated';
		}
	}

	$query = "UPDATE clients SET payment_deadline = b_date WHERE sts = '0'";
			if (!mysql_query($query))
					{
					die('Error: ' . mysql_error());
					} 
mysql_close($con);
	
function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

$curl = curl_init();
$urlfff = $weblink.'cron_auto_gen_bill_mac.php';
curl_setopt($curl, CURLOPT_URL, $urlfff);
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$respd = curl_exec($curl);
curl_close($curl);

$curls = curl_init();
$urlff = $weblink.'cron_auto_gen_bill_invoice.php';
curl_setopt($curls, CURLOPT_URL, $urlff);
curl_setopt($curls, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt($curls, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec($curls);
curl_close($curls);
?>